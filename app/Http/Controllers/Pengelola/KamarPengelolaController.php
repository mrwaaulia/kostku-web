<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\User;
use App\Models\Kost;

class KamarPengelolaController extends Controller
{
    public function viewKamar()
    {
        if (!Auth::check() || Auth::user()->role !== 'pengelola') {
            if (Auth::check() && Auth::user()->role === 'penghuni') {
                return redirect()->route('dashboard.penghuni');
            }

            return redirect()->route('login');
        }

        $kosts = Kost::where('user_id', Auth::id())->get();

        // Ambil semua kamar dari semua kost milik pengelola ini
        $allKamars = Kamar::query()
            ->whereIn('kode_kost', $kosts->pluck('id'))
            ->with('penghuni')
            ->get();

        return view('pages.pengelola.kamar-pengelola', compact('kosts', 'allKamars'));
    }

    public function storeKamar(Request $request)
    {
        $request->validate([
            'nomor_kamar'  => 'required|string|max:255',
            'tipe_kamar'   => 'required|string|max:255',
            'harga'        => 'required|numeric',
            'fasilitas'    => 'required|string',
        ]);

        $kost = Kost::where('user_id', Auth::id())->first();

        if (!$kost) {
            return redirect()->back()->with('error', 'Anda harus membuat data kost terlebih dahulu sebelum menambah kamar!');
        }

        $kost->kamars()->create([
            'nomor_kamar' => $request->nomor_kamar,
            'kode_kost'   => $kost->id,
            'tipe_kamar'  => $request->tipe_kamar,
            'harga'       => $request->harga,
            'status'      => 'kosong',
            'fasilitas'   => $request->fasilitas,
            'user_id'     => Auth::id(),
        ]);

        return redirect()->route('kamar.pengelola')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function updateKamar(Request $request,User  $id)
    {
        $request->validate([
            'nomor_kamar'  => 'required|string|max:255',
            'tipe_kamar'   => 'required|string|max:255',
            'harga'        => 'required|numeric',
            'fasilitas'    => 'required|string',
        ]);

        $kamar = Kost::where('user_id', Auth::id())->first()->kamars()->findOrFail($id);

        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_kamar'  => $request->tipe_kamar,
            'harga'       => $request->harga,
            'fasilitas'   => $request->fasilitas,
        ]);

        return redirect()->back()->with('success', 'Kamar berhasil diperbarui!');
    }

    public function deleteKamar($id)
    {
        $kamar = Kost::where('user_id', Auth::id())->first()->kamars()->findOrFail($id);
        $kamar->delete();

        return redirect()->route('kamar.pengelola')->with('success', 'Kamar berhasil dihapus!');
    }
}
