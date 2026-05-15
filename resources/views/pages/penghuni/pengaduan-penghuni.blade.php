@extends('layouts.penghuni')
@section('title', 'Pengaduan Penghuni')

@section('content')

<div x-data="{ modalOpen: false, modalType: null,
                openModal(type, duration = 2500) {
            this.modalOpen = true;
            this.modalType = type;

            setTimeout(() => {
                this.modalOpen = false;
                this.modalType = null;
            }, duration)
        } }">

    <x-card class="mb-8">
        <h1 class="lg:text-2xl text-xl text-black font-semibold mb-4">
            Buat Pengaduan Baru
        </h1>

        <div class="mb-4">
            <h3 class="lg:text-md text-sm text-black font-semibold mb-2">
                Judul Pengajuan
            </h3>

            <x-form.input
                name="judul-pengajuan"
                placeholder="Contoh: WiFi ngelag"
                class="mb-4 bg-[#F8F8F8]" />
        </div>

        <div class="mb-4">
            <h3 class="lg:text-md text-sm text-black font-semibold mb-2">
                Deskripsi Pengajuan
            </h3>

            <x-form.textarea
                name="deskripsi-pengajuan"
                col="4"
                placeholder="Jelaskan masalah Anda secara detail..."
                class="mb-4 bg-[#F8F8F8]" />
        </div>

        <x-form.button
            type="button"
            @click="openModal('kirim-success')">

            Kirim Pengaduan

        </x-form.button>

    </x-card>

    <h1 class="lg:text-xl text-lg text-black font-semibold mb-4">
        Riwayat Pengaduan
    </h1>

    <x-card>

        <x-table.index class="min-w-[700px]">

            <thead class="sticky top-0 bg-white z-10 border-default">

                <x-table.tr>

                    <x-table.th>
                        Tanggal Pengaduan
                    </x-table.th>

                    <x-table.th>
                        Status
                    </x-table.th>

                    <x-table.th>
                        Detail Pengaduan
                    </x-table.th>

                </x-table.tr>

            </thead>

            <tbody>

                <x-table.tr>

                    <x-table.td class="font-medium text-heading">
                        08/04/2026
                    </x-table.td>

                    <x-table.td>
                        <x-badge type="success">
                            Selesai
                        </x-badge>
                    </x-table.td>

                    <x-table.td>

                        <a
                            href="#"
                            @click.prevent="modalOpen = true; modalType = 'detail-pengaduan'"
                            class="w-28 flex justify-center cursor-pointer">

                            <img
                                src="{{ asset('assets/icons/lihat-detail-icon.png') }}"
                                alt="Lihat Detail"
                                class="w-4 h-4">

                        </a>

                    </x-table.td>

                </x-table.tr>

            </tbody>

        </x-table.index>

    </x-card>

    {{-- ================= MODAL ================= --}}
    <x-modal show="modalOpen" maxWidth="lg:max-w-[450px] max-w-[350px]">

        <template x-if="modalType === 'detail-pengaduan'">

            <div class="relative">

                {{-- CLOSE BUTTON --}}
                <button
                    type="button"
                    class="
                        absolute top-0 right-0
                        text-neutral hover:text-black
                        text-xl font-bold
                    "
                    @click="
                        modalOpen = false;
                        modalType = null;
                    ">

                    ✕

                </button>

                <h2 class="text-xl font-bold mb-8">
                    Detail Pengaduan
                </h2>

                <div class="flex flex-col gap-4">

                    <div>
                        <x-card class="bg-[#EDF2FF] py-5 shadow-none">
                            <h3 class="lg:text-md text-sm text-black font-semibold mb-2">
                                Wifi ngelag
                            </h3>
                            <p class="text-xs text-neutral mb-3">WiFi lambat internetnya sudah dari kemarin</p>
                            <div class="flex justify-around">
                                <p class="text-xs text-neutral">P001 - Anto Subagja</p>
                                <p class="text-xs text-neutral">KM001</p>
                            </div>
                        </x-card>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Balasan Pengelola</label>
                        <div class="w-full
                    rounded-xl bg-[#F8F8F8] border-2 border-[#E2E2E2]
                    px-4
                    py-3">
                            <p class="text-xs text-black mb-1">
                                Baik, terima kasih sudah memberi tahu, akan segera diperbaiki
                            </p>

                            <p class="text-[10px] text-neutral text-right">
                                07/05/2026 10.00
                            </p>
                        </div>
                    </div>

                    <div>
                        <x-form.input
                            label="Status"
                            name="status-pengaduan"
                            class="bg-[#F8F8F8] border-[#E2E2E2]"
                            placeholder="Selesai" disabled />
                    </div>
                </div>
            </div>

        </template>

        {{-- ================= SUCCESS KIRIM ==================== --}}
        <template x-if="modalType === 'kirim-success'">

            <div class="text-center">

                <div class="flex justify-center mb-4">

                    <div class="w-20 h-20 flex items-center justify-center">

                        <img
                            src="{{ asset('assets/icons/success-modal-icon.png') }}"
                            class="w-12">

                    </div>

                </div>

                <h2 class="lg:text-xl text-md font-bold mb-2">
                    Pengaduan berhasil dikirim
                </h2>

            </div>

        </template>
    </x-modal>

</div>

@endsection