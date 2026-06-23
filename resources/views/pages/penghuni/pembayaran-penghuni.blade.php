@extends('layouts.penghuni')
@section('title', 'Pembayaran Penghuni')

@section('content')
<div x-data="pembayaranPage({{ json_encode([
    'pending'    => $pending ? [
        'id'                => $pending->id,
        'id_pembayaran'     => $pending->id_pembayaran,
        'nominal'           => $pending->nominal,
        'tipe_pembayaran'   => $pending->tipe_pembayaran,
        'tanggal_pembayaran'=> $pending->tanggal_pembayaran,
    ] : null,
    'cicilan1'   => $cicilan1 ? [
        'id'                => $cicilan1->id,
        'id_pembayaran'     => $cicilan1->id_pembayaran,
        'nominal'           => $cicilan1->nominal,
        'status'            => $cicilan1->status,
        'tanggal_pembayaran'=> $cicilan1->tanggal_pembayaran,
    ] : null,
    'cicilan2'   => $cicilan2 ? [
        'id'                => $cicilan2->id,
        'id_pembayaran'     => $cicilan2->id_pembayaran,
        'nominal'           => $cicilan2->nominal,
        'status'            => $cicilan2->status,
        'tanggal_pembayaran'=> $cicilan2->tanggal_pembayaran,
    ] : null,
    'sudahLunas' => $sudahLunas,
    'adaTagihan' => $adaTagihan,
]) }})">

    <x-page-header
        title="Pembayaran"
        description="Tagihan dan riwayat pembayaran Anda">
    </x-page-header>

    {{-- Notifikasi Status Pembayaran --}}
    @if(session('payment_status'))
    <div class="mb-4 p-4 rounded-lg
        {{ session('payment_status') === 'finish' ? 'bg-green-50 border border-green-200 text-green-800' : '' }}
        {{ session('payment_status') === 'unfinish' ? 'bg-yellow-50 border border-yellow-200 text-yellow-800' : '' }}
        {{ session('payment_status') === 'error' ? 'bg-red-50 border border-red-200 text-red-800' : '' }}">
        @if(session('payment_status') === 'finish')
        Pembayaran berhasil. Terima kasih.
        @elseif(session('payment_status') === 'unfinish')
        Pembayaran belum selesai. Silakan lanjutkan kembali.
        @elseif(session('payment_status') === 'error')
        Terjadi kesalahan pada proses pembayaran.
        @endif
    </div>
    @endif

    {{-- ================= INFO TAGIHAN ================= --}}
    <x-card class="mb-4">
        <div class="flex flex-col lg:gap-8 gap-4">

            {{-- NOMINAL --}}
            <div>
                <p class="text-neutral text-xs font-medium mb-2">Total Tagihan Sisa</p>
                <h1 class="text-primary lg:text-3xl text-2xl font-bold" x-text="formatRupiah(sisaTagihan)"></h1>
            </div>

            {{-- PERIODE & JATUH TEMPO --}}
            <div class="flex lg:flex-row lg:gap-96 gap-20">
                <div>
                    <p class="text-xs text-neutral mb-2">Periode Tagihan</p>
                    <p class="text-black text-sm font-bold">
                        {{ $pending ? \Carbon\Carbon::parse($pending->tanggal_pembayaran)->format('F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-neutral mb-2">Jatuh Tempo</p>
                    <p class="text-black text-sm font-bold">
                        {{ $pending ? \Carbon\Carbon::parse($pending->tanggal_pembayaran)->format('d F Y') : '-' }}
                    </p>
                </div>
            </div>



            {{-- TOMBOL AKSI --}}

            {{-- Belum ada tagihan sama sekali --}}
            <template x-if="!adaTagihan">
                <div>
                    <button disabled class="w-full bg-gray-200 text-gray-400 cursor-not-allowed lg:text-md text-sm font-bold lg:p-3 p-2 rounded-md">
                        Belum Ada Tagihan
                    </button>
                </div>
            </template>

            {{-- Sudah lunas semua --}}
            <template x-if="adaTagihan && sudahLunas">
                <div>
                    <button disabled class="w-full bg-gray-200 text-gray-400 cursor-not-allowed lg:text-md text-sm font-bold lg:p-3 p-2 rounded-md">
                        Sudah Dibayar
                    </button>
                </div>
            </template>

            {{-- Cicilan 1 sudah lunas, cicilan 2 belum --}}
            <template x-if="adaTagihan && !sudahLunas && cicilan1 && cicilan1.status === 'lunas' && cicilan2 && cicilan2.status === 'belum_bayar'">
                <div>
                    <button
                        @click="modalOpen = true; modalType = 'lanjut-cicilan'"
                        class="w-full bg-primary hover:bg-secondary text-white hover:text-primary lg:text-md text-sm font-bold lg:p-3 p-2 rounded-md">
                        Lanjutkan Cicilan
                    </button>
                </div>
            </template>

            {{-- Belum bayar apapun (ada pending, belum ada cicilan aktif) --}}
            <template x-if="adaTagihan && !sudahLunas && !(cicilan1 && cicilan1.status === 'lunas') && pending">
                <div class="flex gap-4">
                    <button
                        @click="modalOpen = true; modalType = 'bayar-lunas'"
                        class="w-full bg-primary hover:bg-secondary text-white hover:text-primary lg:text-md text-sm font-bold lg:p-3 p-2 rounded-md">
                        Bayar Lunas
                    </button>
                    <button
                        @click="modalOpen = true; modalType = 'bayar-cicilan'"
                        class="w-full border-2 border-primary hover:bg-secondary hover:border-secondary text-primary lg:text-md text-sm font-bold lg:p-3 p-2 rounded-md">
                        Bayar Cicilan
                    </button>
                </div>
            </template>

            {{-- Cicilan 1 belum bayar (sudah dipecah tapi belum dibayar) --}}
            <template x-if="adaTagihan && !sudahLunas && cicilan1 && cicilan1.status === 'belum_bayar'">
                <div>
                    <button
                        @click="modalOpen = true; modalType = 'bayar-cicilan-aktif'"
                        class="w-full bg-primary hover:bg-secondary text-white hover:text-primary lg:text-md text-sm font-bold lg:p-3 p-2 rounded-md">
                        Bayar Cicilan Pertama
                    </button>
                </div>
            </template>

        </div>
    </x-card>

    {{-- ================= RIWAYAT PEMBAYARAN ================= --}}
    <x-card>
        <h1 class="text-black text-xl font-bold mb-4">Riwayat Pembayaran</h1>
        <x-table.index class="min-w-[700px]">
            <thead class="sticky top-0 bg-white z-10 border-b border-default">
                <x-table.tr>
                    <x-table.th>Tanggal Pembayaran</x-table.th>
                    <x-table.th>Jenis</x-table.th>
                    <x-table.th>Nominal</x-table.th>
                    <x-table.th>Status</x-table.th>
                    <x-table.th>Aksi</x-table.th>
                </x-table.tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                <x-table.tr>
                    <x-table.td class="font-medium text-heading">
                        {{ \Carbon\Carbon::parse($item->paid_at ?? $item->tanggal_pembayaran)->format('d/m/Y') }}
                    </x-table.td>
                    <x-table.td>
                        @if(str_contains($item->id_pembayaran, '-c1-'))
                        Cicilan 1
                        @elseif(str_contains($item->id_pembayaran, '-c2-'))
                        Cicilan 2
                        @else
                        Lunas
                        @endif
                    </x-table.td>
                    <x-table.td>
                        Rp{{ number_format($item->nominal, 0, ',', '.') }}
                    </x-table.td>
                    <x-table.td>
                        <x-badge type="success">Berhasil</x-badge>
                    </x-table.td>
                    <x-table.td>
                        <a href="#" class="font-medium text-primary hover:underline">Lihat Struk</a>
                    </x-table.td>
                </x-table.tr>
                @empty
                <x-table.tr>
                    <x-table.td colspan="5" class="text-center text-neutral">
                        Belum ada riwayat pembayaran.
                    </x-table.td>
                </x-table.tr>
                @endforelse
            </tbody>
        </x-table.index>

        <div class="mt-4">
            <p class="text-xs text-neutral">Menampilkan {{ $history->count() }} data</p>
        </div>
    </x-card>

    <div class="mt-4">
        <x-pagination :paginator="$history" />
    </div>

    {{-- ================= MODAL ================= --}}
    <x-modal show="modalOpen" maxWidth="lg:max-w-[450px] max-w-[350px]">

        {{-- BAYAR LUNAS --}}
        <template x-if="modalType === 'bayar-lunas'">
            <div class="relative">
                <button type="button" class="absolute top-0 right-0 text-neutral hover:text-black text-xl font-bold"
                    @click="modalOpen = false; modalType = null; alertMessage = null">✕</button>

                <h2 class="text-xl font-bold mb-8">Konfirmasi Pembayaran Lunas</h2>

                <div class="flex flex-col gap-4">
                    <div class="flex justify-between border-b-2 pb-2">
                        <p class="text-xs text-neutral" x-text="'Tagihan ' + periodeTagihan"></p>
                        <p class="text-sm text-black font-semibold" x-text="formatRupiah(pending?.nominal ?? 0)"></p>
                    </div>
                    <div class="flex justify-between border-b-2 pb-2">
                        <p class="text-md text-black font-medium">Total Pembayaran</p>
                        <p class="text-md text-primary font-semibold" x-text="formatRupiah(pending?.nominal ?? 0)"></p>
                    </div>
                </div>

                <template x-if="alertMessage">
                    <div class="mt-4 p-3 rounded-md bg-red-50 text-red-700">
                        <p x-text="alertMessage"></p>
                    </div>
                </template>

                <button
                    type="button"
                    class="w-full bg-primary hover:bg-secondary text-white hover:text-primary lg:text-md text-sm font-bold lg:p-3 p-2 rounded-md mt-8"
                    :disabled="isLoading"
                    @click="payNow(pending)">
                    <span x-text="isLoading ? 'Memproses...' : 'Bayar Sekarang'"></span>
                </button>
            </div>
        </template>

        {{-- BAYAR CICILAN (pemilihan metode cicilan, cicilan belum dipecah) --}}
        <template x-if="modalType === 'bayar-cicilan'">
            <div class="relative">
                <button type="button" class="absolute top-0 right-0 text-neutral hover:text-black text-xl font-bold"
                    @click="modalOpen = false; modalType = null; alertMessage = null">✕</button>

                <h2 class="text-xl font-bold">Konfirmasi Pembayaran Cicilan</h2>
                <p class="text-xs text-neutral mb-8">Total tagihan dibagi menjadi 2 pembayaran</p>

                <div class="flex flex-col gap-4">
                    <div class="flex flex-col border-2 border-primary p-4 rounded-lg">
                        <p class="text-lg text-black font-medium">Cicilan Pertama</p>
                        <p class="text-sm text-neutral my-1">Dibayar sekarang</p>
                        <p class="text-xl text-primary font-semibold" x-text="formatRupiah(Math.floor((pending?.nominal ?? 0) / 2))"></p>
                        <button
                            type="button"
                            class="w-full bg-primary hover:bg-secondary text-white hover:text-primary text-sm font-bold p-2 rounded-md mt-4"
                            :disabled="isLoading"
                            @click="payNowCicilan(pending)">
                            <span x-text="isLoading ? 'Memproses...' : 'Bayar Cicilan Pertama'"></span>
                        </button>
                    </div>

                    <div class="flex flex-col border-2 border-primary/30 p-4 rounded-lg opacity-60">
                        <p class="text-lg text-black font-medium">Cicilan Kedua</p>
                        <p class="text-sm text-neutral my-1">Dibayar 2 minggu kemudian</p>
                        <p class="text-xl text-primary font-semibold" x-text="formatRupiah((pending?.nominal ?? 0) - Math.floor((pending?.nominal ?? 0) / 2))"></p>
                        <button disabled class="w-full bg-gray-200 text-gray-400 cursor-not-allowed text-sm font-bold p-2 rounded-md mt-4">
                            Tersedia setelah cicilan 1 lunas
                        </button>
                    </div>
                </div>

                <template x-if="alertMessage">
                    <div class="mt-4 p-3 rounded-md bg-red-50 text-red-700">
                        <p x-text="alertMessage"></p>
                    </div>
                </template>
            </div>
        </template>

        {{-- BAYAR CICILAN AKTIF (c1 sudah ada di DB tapi belum dibayar) --}}
        <template x-if="modalType === 'bayar-cicilan-aktif'">
            <div class="relative">
                <button type="button" class="absolute top-0 right-0 text-neutral hover:text-black text-xl font-bold"
                    @click="modalOpen = false; modalType = null; alertMessage = null">✕</button>

                <h2 class="text-xl font-bold mb-8">Bayar Cicilan Pertama</h2>

                <div class="flex flex-col border-2 border-primary p-4 rounded-lg">
                    <p class="text-lg text-black font-medium">Cicilan Pertama</p>
                    <p class="text-sm text-neutral my-1">Segera selesaikan pembayaran</p>
                    <p class="text-xl text-primary font-semibold" x-text="formatRupiah(cicilan1?.nominal ?? 0)"></p>
                    <button
                        type="button"
                        class="w-full bg-primary hover:bg-secondary text-white hover:text-primary text-sm font-bold p-2 rounded-md mt-4"
                        :disabled="isLoading"
                        @click="payNow(cicilan1)">
                        <span x-text="isLoading ? 'Memproses...' : 'Bayar Sekarang'"></span>
                    </button>
                </div>

                <template x-if="alertMessage">
                    <div class="mt-4 p-3 rounded-md bg-red-50 text-red-700">
                        <p x-text="alertMessage"></p>
                    </div>
                </template>
            </div>
        </template>

        {{-- LANJUT CICILAN (c1 lunas, bayar c2) --}}
        <template x-if="modalType === 'lanjut-cicilan'">
            <div class="relative">
                <button type="button" class="absolute top-0 right-0 text-neutral hover:text-black text-xl font-bold"
                    @click="modalOpen = false; modalType = null; alertMessage = null">✕</button>

                <h2 class="text-xl font-bold">Konfirmasi Pembayaran Cicilan</h2>
                <p class="text-xs text-neutral mb-8">Melanjutkan cicilan kedua</p>

                <div class="flex flex-col border-2 border-primary p-4 rounded-lg">
                    <p class="text-lg text-black font-medium">Cicilan Kedua</p>
                    <p class="text-sm text-neutral my-1">Pembayaran terakhir</p>
                    <p class="text-xl text-primary font-semibold" x-text="formatRupiah(cicilan2?.nominal ?? 0)"></p>
                    <button
                        type="button"
                        class="w-full bg-primary hover:bg-secondary text-white hover:text-primary text-sm font-bold p-2 rounded-md mt-4"
                        :disabled="isLoading"
                        @click="payNow(cicilan2)">
                        <span x-text="isLoading ? 'Memproses...' : 'Bayar Cicilan Kedua'"></span>
                    </button>
                </div>

                <template x-if="alertMessage">
                    <div class="mt-4 p-3 rounded-md bg-red-50 text-red-700">
                        <p x-text="alertMessage"></p>
                    </div>
                </template>
            </div>
        </template>

    </x-modal>

    {{-- Script Midtrans --}}
    <script src="{{ config('midtrans.isProduction') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>

    <script>
        function pembayaranPage({
            pending,
            cicilan1,
            cicilan2,
            sudahLunas,
            adaTagihan
        }) {
            return {
                modalOpen: false,
                modalType: null,
                isLoading: false,
                alertMessage: null,
                pending,
                cicilan1,
                cicilan2,
                sudahLunas,
                adaTagihan,

                get sisaTagihan() {
                    if (!this.adaTagihan || this.sudahLunas) return 0;
                    // Jika cicilan 1 sudah lunas, sisa = nominal cicilan 2
                    if (this.cicilan1 && this.cicilan1.status === 'lunas' && this.cicilan2) {
                        return this.cicilan2.nominal;
                    }
                    // Jika cicilan 1 belum lunas, sisa = nominal cicilan 1
                    if (this.cicilan1 && this.cicilan1.status === 'belum_bayar') {
                        return this.cicilan1.nominal;
                    }
                    // Mode lunas biasa
                    return this.pending?.nominal ?? 0;
                },

                get periodeTagihan() {
                    const tgl = this.pending?.tanggal_pembayaran ??
                        this.cicilan1?.tanggal_pembayaran ??
                        this.cicilan2?.tanggal_pembayaran;
                    if (!tgl) return '-';
                    return new Date(tgl).toLocaleString('id-ID', {
                        month: 'long',
                        year: 'numeric'
                    });
                },

                get jatuhTempo() {
                    const tgl = this.pending?.tanggal_pembayaran ??
                        this.cicilan1?.tanggal_pembayaran ??
                        this.cicilan2?.tanggal_pembayaran;
                    if (!tgl) return '-';
                    return new Date(tgl).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                },

                formatRupiah(nominal) {
                    return 'Rp' + Number(nominal).toLocaleString('id-ID');
                },

                async verifyAndReload(paymentId) {
                    try {
                        await axios.post('/payment/verify', {
                            pembayaran_id: paymentId
                        });
                    } catch (e) {
                        // tetap reload
                    } finally {
                        window.location.reload();
                    }
                },

                startSnap(snapToken, paymentId) {
                    window.snap.pay(snapToken, {
                        onSuccess: (result) => {
                            this.modalOpen = false;
                            this.verifyAndReload(paymentId);
                        },
                        onPending: () => {
                            this.alertMessage = 'Pembayaran pending. Silakan selesaikan pembayaran Anda.';
                            this.isLoading = false;
                        },
                        onError: (result) => {
                            this.alertMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                            this.isLoading = false;
                        },
                        onClose: () => {
                            this.alertMessage = 'Pembayaran dibatalkan.';
                            this.isLoading = false;
                        }
                    });
                },

                // Bayar lunas atau cicilan yang sudah ada di DB (c1/c2)
                payNow(pembayaran) {
                    if (!pembayaran) {
                        this.alertMessage = 'Tidak ada tagihan aktif.';
                        return;
                    }
                    this.isLoading = true;
                    this.alertMessage = null;

                    axios.post('/payment/create', {
                            pembayaran_id: pembayaran.id
                        })
                        .then(response => {
                            const snap_token = response.data.snap_token;
                            const payment_id = response.data.payment_id;
                            if (!snap_token) throw new Error('Token tidak ditemukan.');
                            this.startSnap(snap_token, payment_id);
                        })
                        .catch(error => {
                            this.alertMessage = error.response?.data?.message || error.message;
                            this.isLoading = false;
                        });
                },

                // Bayar cicilan baru (pecah dari induk, is_cicilan: true)
                async payNowCicilan(pembayaran) {
                    if (!pembayaran) {
                        this.alertMessage = 'Tidak ada tagihan aktif.';
                        return;
                    }
                    this.isLoading = true;
                    this.alertMessage = null;

                    try {
                        // Step 1: pecah jadi 2 cicilan, dapat cicilan1_id
                        const splitRes = await axios.post('/payment/create', {
                            pembayaran_id: pembayaran.id,
                            is_cicilan: true
                        });

                        const cicilan1Id = splitRes.data.cicilan1_id;
                        if (!cicilan1Id) throw new Error('cicilan1_id tidak ditemukan.');

                        // Step 2: generate snap token untuk cicilan 1
                        const payRes = await axios.post('/payment/create', {
                            pembayaran_id: cicilan1Id
                        });

                        const snapToken = payRes.data.snap_token;
                        const paymentId = payRes.data.payment_id;
                        if (!snapToken) throw new Error('Token tidak ditemukan.');

                        this.startSnap(snapToken, paymentId);

                    } catch (error) {
                        this.alertMessage = error.response?.data?.message || error.message;
                        this.isLoading = false;
                    }
                },
                get sisaTagihan() {
                    if (!this.adaTagihan || this.sudahLunas) return 0;

                    // Semua cicilan lunas
                    if (
                        this.cicilan1 && this.cicilan1.status === 'lunas' &&
                        this.cicilan2 && this.cicilan2.status === 'lunas'
                    ) return 0;

                    // Cicilan 1 sudah lunas, sisa = cicilan 2
                    if (this.cicilan1 && this.cicilan1.status === 'lunas' && this.cicilan2) {
                        return this.cicilan2.nominal;
                    }

                    // Cicilan 1 belum lunas
                    if (this.cicilan1 && this.cicilan1.status === 'belum_bayar') {
                        return this.cicilan1.nominal;
                    }

                    // Mode lunas biasa
                    return this.pending?.nominal ?? 0;
                },
            }
        }
    </script>
</div>
@endsection