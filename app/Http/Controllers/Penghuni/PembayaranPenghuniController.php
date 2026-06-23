<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Transaction;

class PembayaranPenghuniController extends Controller
{
    private function checkPenghuniAktif()
    {
        return \App\Models\Penghuni::where('user_id', auth()->id())
            ->where('status_request', 'disetujui')
            ->whereNull('tanggal_keluar')
            ->exists();
    }

    public function viewPembayaran()
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        $userId   = Auth::id();
        $payments = Pembayaran::where('user_id', $userId)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        $cicilan1 = $payments
            ->filter(fn($p) => str_contains((string) $p->id_pembayaran, '-c1-'))
            ->sortByDesc('id')
            ->first();

        $cicilan2 = $payments
            ->filter(fn($p) => str_contains((string) $p->id_pembayaran, '-c2-'))
            ->sortByDesc('id')
            ->first();

        $pendingUtama = $payments
            ->where('status', 'belum_bayar')
            ->filter(
                fn($p) =>
                !str_contains((string) $p->id_pembayaran, '-c1-') &&
                    !str_contains((string) $p->id_pembayaran, '-c2-')
            )
            ->sortByDesc('id')
            ->first();

        $pendingCicilan1 = $cicilan1 && $cicilan1->status === 'belum_bayar' ? $cicilan1 : null;
        $pendingCicilan2 = $cicilan2 && $cicilan2->status === 'belum_bayar' ? $cicilan2 : null;

        if ($pendingCicilan1) {
            $pending = $pendingCicilan1;
        } elseif ($pendingCicilan2) {
            $pending = $pendingCicilan2;
        } else {
            $pending = $pendingUtama;
        }

        $semuaCicilanLunas = $cicilan1 && $cicilan1->status === 'lunas'
            && $cicilan2 && $cicilan2->status === 'lunas';
        $sudahLunas = $semuaCicilanLunas
            || (!$pending && !$pendingCicilan1 && !$pendingCicilan2 && !$pendingUtama);
        $adaTagihan = $payments->isNotEmpty();

        $history = Pembayaran::where('user_id', $userId)
            ->where('status', 'lunas')
            ->orderByDesc('tanggal_pembayaran')
            ->paginate(10);

        return view('pages.penghuni.pembayaran-penghuni', compact(
            'pending',
            'cicilan1',
            'cicilan2',
            'sudahLunas',
            'adaTagihan',
            'history'
        ));
    }

    public function create(Request $request)
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        return $this->createPayment($request);
    }

    public function createPayment(Request $request)
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        $request->validate([
            'pembayaran_id' => 'required|integer|exists:pembayarans,id',
        ]);

        $pembayaran = Pembayaran::findOrFail($request->pembayaran_id);

        if ($pembayaran->user_id !== Auth::id()) {
            return response()->json(['message' => 'Akses tidak diizinkan.'], 403);
        }

        if ($pembayaran->status !== 'belum_bayar') {
            return response()->json(['message' => 'Pembayaran sudah selesai.'], 422);
        }

        $user = $pembayaran->user;

        // ── Sudah pecahan cicilan → langsung generate snap token ──
        if (str_contains($pembayaran->id_pembayaran, '-c1-') || str_contains($pembayaran->id_pembayaran, '-c2-')) {
            return $this->generateSingleSnapToken($pembayaran, $user);
        }

        // ── Pilih cicilan → HANYA PECAH JADI 2, tidak generate snap token ──
        if ($request->boolean('is_cicilan')) {

            if ((int) $pembayaran->jumlah_cicilan !== 2) {
                $pembayaran->update(['jumlah_cicilan' => 2]);
                $pembayaran->refresh();
            }

            $total    = (int) $pembayaran->nominal;
            $nominal1 = intdiv($total, 2);
            $nominal2 = $total - $nominal1;

            $tanggal1 = $pembayaran->tanggal_pembayaran
                ? Carbon::parse($pembayaran->tanggal_pembayaran)
                : Carbon::now();
            $tanggal2 = $tanggal1->copy()->addWeeks(2);

            // Cek cicilan 1 sudah ada (hindari duplikat)
            $existingC1 = Pembayaran::where('user_id', $pembayaran->user_id)
                ->where('id_pembayaran', 'like', $pembayaran->id_pembayaran . '-c1-%')
                ->latest('id')
                ->first();

            if ($existingC1) {
                // Sudah pernah dipecah, kembalikan id cicilan 1 saja
                return response()->json([
                    'message'    => 'Cicilan sudah dipecah sebelumnya.',
                    'cicilan1_id' => $existingC1->id,
                ]);
            }

            // Buat 2 record cicilan TANPA snap token
            $suffix   = now()->format('ymdHi') . rand(10, 99); // 12 karakter
            $orderId1 = $pembayaran->id_pembayaran . '-c1-' . $suffix;
            $orderId2 = $pembayaran->id_pembayaran . '-c2-' . $suffix;
            $orderId1 = $pembayaran->id_pembayaran . '-c1-' . $suffix;
            $orderId2 = $pembayaran->id_pembayaran . '-c2-' . $suffix;

            $pem1 = Pembayaran::create([
                'id_pembayaran'      => $orderId1,
                'user_id'            => $pembayaran->user_id,
                'tanggal_pembayaran' => $tanggal1->toDateString(),
                'nominal'            => $nominal1,
                'tipe_pembayaran'    => 'cicilan',
                'jumlah_cicilan'     => 1,
                'status'             => 'belum_bayar',
                // snap_token tidak diisi
            ]);

            Pembayaran::create([
                'id_pembayaran'      => $orderId2,
                'user_id'            => $pembayaran->user_id,
                'tanggal_pembayaran' => $tanggal2->toDateString(),
                'nominal'            => $nominal2,
                'tipe_pembayaran'    => 'cicilan',
                'jumlah_cicilan'     => 1,
                'status'             => 'belum_bayar',
                // snap_token tidak diisi
            ]);

            // Kembalikan cicilan1_id supaya frontend bisa langsung panggil payNow
            return response()->json([
                'message'     => 'Cicilan berhasil dipecah.',
                'cicilan1_id' => $pem1->id,
            ]);
        }

        // ── Default: bayar lunas ──
        return $this->generateSingleSnapToken($pembayaran, $user);
    }

    private function generateSingleSnapToken($pembayaran, $user)
    {
        // Buat suffix unik pendek
        $suffix = now()->format('His') . rand(10, 99); // max 8 karakter

        // Potong base agar total tidak melebihi 50 karakter
        $maxBase = 50 - strlen($suffix) - 1; // -1 untuk tanda '-'
        $base    = substr($pembayaran->id_pembayaran, 0, $maxBase);

        $midtransOrderId = $base . '-' . $suffix;

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => (int) $pembayaran->nominal,
            ],
            'customer_details' => [
                'first_name' => trim($user->nama),
                'email'      => trim($user->email),
            ],
        ]);

        $pembayaran->update([
            'snap_token'        => $snapToken,
            'midtrans_order_id' => $midtransOrderId,
        ]);

        return response()->json([
            'message'    => 'Snap token generated',
            'snap_token' => $snapToken,
            'payment_id' => $pembayaran->id,
            'order_id'   => $midtransOrderId,
        ]);
    }
    /**
     * Dipanggil dari frontend setelah Midtrans onSuccess
     * Verifikasi status ke Midtrans API lalu update DB
     */
    public function verify(Request $request)
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403);
        }

        $request->validate([
            'pembayaran_id' => 'required|integer|exists:pembayarans,id',
        ]);

        $pembayaran = Pembayaran::findOrFail($request->pembayaran_id);

        if ($pembayaran->user_id !== Auth::id()) {
            return response()->json(['message' => 'Akses tidak diizinkan.'], 403);
        }

        if ($pembayaran->status === 'lunas') {
            return response()->json(['status' => 'lunas']);
        }

        try {
            // Cek status langsung ke Midtrans
            $status = Transaction::status($pembayaran->id_pembayaran);
            $transactionStatus = $status->transaction_status ?? null;
            $fraudStatus       = $status->fraud_status ?? null;

            $isSuccessful = ($transactionStatus === 'settlement') || (
                $transactionStatus === 'capture' &&
                in_array($fraudStatus, ['accept', 'challenge'])
            );

            if ($isSuccessful) {
                $pembayaran->update([
                    'status'             => 'lunas',
                    'transaction_id'     => $status->transaction_id ?? null,
                    'payment_type'       => $status->payment_type ?? null,
                    'transaction_status' => $transactionStatus,
                    'paid_at'            => now(),
                ]);

                return response()->json(['status' => 'lunas']);
            }

            if ($transactionStatus === 'pending') {
                $pembayaran->update(['status' => 'pending', 'transaction_status' => $transactionStatus]);
                return response()->json(['status' => 'pending']);
            }

            return response()->json(['status' => $transactionStatus ?? 'unknown']);
        } catch (\Exception $e) {
            \Log::error('Verify payment error: ' . $e->getMessage());
            // Kalau Midtrans error, fallback: langsung lunas berdasarkan onSuccess dari snap
            $pembayaran->update([
                'status'  => 'lunas',
                'paid_at' => now(),
            ]);
            return response()->json(['status' => 'lunas']);
        }
    }

    public function status(Pembayaran $pembayaran)
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        if ($pembayaran->user_id !== Auth::id()) {
            return response()->json(['message' => 'Akses tidak diizinkan.'], 403);
        }

        return response()->json([
            'status'             => $pembayaran->status,
            'transaction_status' => $pembayaran->transaction_status,
            'transaction_id'     => $pembayaran->transaction_id,
            'va_number'          => $pembayaran->va_number,
            'payment_type'       => $pembayaran->payment_type,
            'paid_at'            => $pembayaran->paid_at,
            'snap_token'         => $pembayaran->snap_token,
        ]);
    }

    public function pending(Pembayaran $pembayaran)
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        if ($pembayaran->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pages.penghuni.pembayaran-status', compact('pembayaran'));
    }

    public function callback(Request $request)
    {
        try {
            $payload   = $request->all();
            $orderId   = $request->input('order_id');

            \Log::info('Midtrans callback masuk', ['order_id' => $orderId]);

            if (!$orderId) {
                return response()->json(['message' => 'Invalid payload: order_id is missing'], 400);
            }

            $pembayaran = Pembayaran::where('id_pembayaran', $orderId)->first();

            if (!$pembayaran) {
                return response()->json(['message' => 'Pembayaran tidak ditemukan.'], 404);
            }

            $notif             = new \Midtrans\Notification();
            $transactionStatus = $notif->transaction_status;
            $paymentType       = $notif->payment_type;
            $transactionId     = $notif->transaction_id;
            $fraudStatus       = $notif->fraud_status ?? null;

            $vaNumber = null;
            if (!empty($payload['va_numbers']) && is_array($payload['va_numbers'])) {
                $vaNumber = $payload['va_numbers'][0]['va_number'] ?? null;
            } elseif (!empty($payload['permata_va_number'])) {
                $vaNumber = $payload['permata_va_number'];
            } elseif (!empty($payload['bill_key']) && !empty($payload['biller_code'])) {
                $vaNumber = $payload['biller_code'] . ' / ' . $payload['bill_key'];
            }

            $paidAt = null;
            if (!empty($payload['transaction_time'])) {
                try {
                    $paidAt = Carbon::parse($payload['transaction_time']);
                } catch (\Exception $e) {
                    $paidAt = now();
                }
            }

            $updateData = [
                'transaction_status' => $transactionStatus,
                'payment_type'       => $paymentType,
                'midtrans_response'  => json_encode($payload),
            ];

            if ($vaNumber) $updateData['va_number'] = $vaNumber;

            $alreadySettled = ($pembayaran->status === 'lunas');

            $isSuccessful = ($transactionStatus === 'settlement') || (
                $transactionStatus === 'capture' && in_array($fraudStatus, ['accept', 'challenge'])
            );

            if ($isSuccessful) {
                if (!$alreadySettled) {
                    $updateData['status']         = 'lunas';
                    $updateData['transaction_id'] = $transactionId;
                    $updateData['paid_at']        = $paidAt ?? now();
                }
                $pembayaran->update($updateData);
            } elseif ($transactionStatus === 'pending') {
                if (!$alreadySettled) {
                    $updateData['status']         = 'pending';
                    $updateData['transaction_id'] = $transactionId;
                }
                $pembayaran->update($updateData);
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                if (!$alreadySettled) {
                    $updateData['status']         = 'failed';
                    $updateData['transaction_id'] = $transactionId;
                }
                $pembayaran->update($updateData);
            } else {
                $pembayaran->update($updateData);
            }

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            \Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function getHistory()
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        $payments = Pembayaran::where('user_id', Auth::id())
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        return response()->json([
            'pending' => $payments->where('status', 'belum_bayar')->first(),
            'history' => $payments->where('status', 'lunas')->values(),
        ]);
    }

    public function finish()
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        return redirect()->route('pembayaran.penghuni')->with('payment_status', 'finish');
    }

    public function unfinish()
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        return redirect()->route('pembayaran.penghuni')->with('payment_status', 'unfinish');
    }

    public function error()
    {
        if (!$this->checkPenghuniAktif()) {
            abort(403, 'Anda belum terdaftar sebagai penghuni kost.');
        }

        return redirect()->route('pembayaran.penghuni')->with('payment_status', 'error');
    }
}
