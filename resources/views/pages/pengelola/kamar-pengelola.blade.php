@extends('layouts.pengelola')
@section('title', 'Kamar')

@section('content')

<div
    x-data="{
        activeTab: 'semua',

        modalOpen: false,
        modalType: null,

        successMessage: '',

        kamarStatus: 'terisi',

        openModal(type) {
            this.modalOpen = true;
            this.modalType = type;
        },

        closeModal() {
            this.modalOpen = false;
            this.modalType = null;
        },

        showSuccess(message) {
            this.successMessage = message;
            this.modalType = 'success';

            setTimeout(() => {
                this.closeModal();
            }, 2200);
        }
    }"
    x-init="@if(session('success')) modalOpen = true; modalType = 'success'; successMessage = '{{ session('success') }}'; @elseif(session('error')) modalOpen = true; modalType = 'success'; successMessage = '{{ session('error') }}'; @endif">

    {{-- ================= PAGE HEADER ================= --}}
    <x-page-header
        title="Data Kamar"
        description="Kelola kamar kost dan informasi penghuni">

        <x-slot name="action">

            <x-form.button
                type="button"
                class="lg:w-auto w-[140px]"
                @click="openModal('tambah-kamar')">

                Tambah Kamar

            </x-form.button>

        </x-slot>

    </x-page-header>


    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-xl p-4 lg:p-6 mb-6 shadow-sm">

        {{-- ================= TAB ================= --}}
        <div class="flex gap-6 border-b mb-6 overflow-x-auto">

            {{-- SEMUA --}}
            <button
                @click="activeTab = 'semua'"
                :class="
                    activeTab === 'semua'
                    ? 'border-primary text-primary font-semibold'
                    : 'border-transparent text-black font-medium'
                "
                class="pb-3 border-b-2 text-sm whitespace-nowrap transition">

                Semua

            </button>

            {{-- KOSONG --}}
            <button
                @click="activeTab = 'kosong'"
                :class="
                    activeTab === 'kosong'
                    ? 'border-primary text-primary font-semibold'
                    : 'border-transparent text-black font-medium'
                "
                class="pb-3 border-b-2 text-sm whitespace-nowrap transition">

                Kosong

            </button>

            {{-- TERISI --}}
            <button
                @click="activeTab = 'terisi'"
                :class="
                    activeTab === 'terisi'
                    ? 'border-primary text-primary font-semibold'
                    : 'border-transparent text-black font-medium'
                "
                class="pb-3 border-b-2 text-sm whitespace-nowrap transition">

                Terisi

            </button>

        </div>


        {{-- ================= TABLE WRAPPER ================= --}}
        <div class="overflow-x-auto overflow-y-auto max-h-[420px]">

            <table class="w-full min-w-[900px]">

                <thead>

                    <tr class="border-b">

                        <th class="py-4 px-3 text-left text-sm font-semibold">
                            Nomor Kamar
                        </th>

                        <th class="py-4 px-3 text-left text-sm font-semibold">
                            Nama Penghuni
                        </th>

                        <th class="py-4 px-3 text-left text-sm font-semibold">
                            Tipe Kamar
                        </th>

                        <th class="py-4 px-3 text-left text-sm font-semibold">
                            Harga
                        </th>

                        <th class="py-4 px-3 text-center text-sm font-semibold">
                            Status
                        </th>

                        <th class="py-4 px-3 text-center text-sm font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- ================= KAMAR TERISI ================= --}}
                <template x-if="activeTab === 'semua' || activeTab === 'terisi'">
                    <tbody class="divide-y divide-gray-200">
                        @forelse($allKamars->where('status', 'terisi') as $kamar)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-4 px-3 text-sm">
                                    {{ $kamar->nomor_kamar }}
                                </td>

                                <td class="py-4 px-3 text-sm">
                                    {{ $kamar->penghuni?->nama ?? '-' }}
                                </td>

                                <td class="py-4 px-3 text-sm">
                                    {{ $kamar->tipe_kamar }}
                                </td>

                                <td class="py-4 px-3 text-sm">
                                    Rp{{ number_format($kamar->harga, 0, ',', '.') }}
                                </td>

                                <td class="py-4 px-3 text-center">
                                    <x-badge type="danger">Terisi</x-badge>
                                </td>

                                <td class="py-4 px-3">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- DETAIL --}}
                                        <button
                                            type="button"
                                            @click="kamarStatus = 'terisi'; detailKamarNomor = '{{ $kamar->nomor_kamar }}'; detailKamarPenghuni = '{{ addslashes($kamar->penghuni?->nama ?? '-') }}'; detailKamarTipe = '{{ addslashes($kamar->tipe_kamar) }}'; detailKamarStatus = '{{ $kamar->status }}'; detailKamarHarga = '{{ $kamar->harga }}'; detailKamarFasilitas = '{{ addslashes($kamar->fasilitas ?? '-') }}'; openModal('detail-kamar')"
                                            class="p-2 rounded-md hover:bg-blue-50 transition">
                                            <img src="{{ asset('assets/icons/lihat-detail-icon.png') }}" class="w-4 h-4">
                                        </button>

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            @click="kamarStatus = 'terisi'; openModal('edit-kamar')"
                                            class="p-2 rounded-md hover:bg-yellow-50 transition">
                                            <img src="{{ asset('assets/icons/edit-icon.png') }}" class="w-4">
                                        </button>

                                        {{-- DELETE --}}
                                        <button
                                            type="button"
                                            @click="kamarStatus = 'terisi'; openModal('cannot-delete')"
                                            class="p-2 rounded-md hover:bg-red-50 transition">
                                            <img src="{{ asset('assets/icons/delete-icon.png') }}" class="w-4">
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr x-show="activeTab === 'terisi'">
                                <td colspan="6" class="py-8 text-center text-gray-500 text-sm">
                                    Tidak ada data kamar terisi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </template>

                {{-- ================= KAMAR KOSONG ================= --}}
                <template x-if="activeTab === 'semua' || activeTab === 'kosong'">
                    <tbody class="divide-y divide-gray-200">
                        @forelse($allKamars->where('status', 'kosong') as $kamar)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-4 px-3 text-sm">
                                    {{ $kamar->nomor_kamar }}
                                </td>

                                <td class="py-4 px-3 text-sm">
                                    {{ $kamar->penghuni?->nama ?? '-' }}
                                </td>

                                <td class="py-4 px-3 text-sm">
                                    {{ $kamar->tipe_kamar }}
                                </td>

                                <td class="py-4 px-3 text-sm">
                                    Rp{{ number_format($kamar->harga, 0, ',', '.') }}
                                </td>

                                <td class="py-4 px-3 text-center">
                                    <x-badge type="success">Kosong</x-badge>
                                </td>

                                <td class="py-4 px-3">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- DETAIL --}}
                                        <button
                                            type="button"
                                            @click="kamarStatus = 'kosong'; detailKamarNomor = '{{ $kamar->nomor_kamar }}'; detailKamarPenghuni = '{{ addslashes($kamar->penghuni?->nama ?? '-') }}'; detailKamarTipe = '{{ addslashes($kamar->tipe_kamar) }}'; detailKamarStatus = '{{ $kamar->status }}'; detailKamarHarga = '{{ $kamar->harga }}'; detailKamarFasilitas = '{{ addslashes($kamar->fasilitas ?? '-') }}'; openModal('detail-kamar')"
                                            class="p-2 rounded-md hover:bg-blue-50 transition">
                                            <img src="{{ asset('assets/icons/lihat-detail-icon.png') }}" class="w-4 h-4">
                                        </button>

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            @click="kamarStatus = 'kosong'; openModal('edit-kamar')"
                                            class="p-2 rounded-md hover:bg-yellow-50 transition">
                                            <img src="{{ asset('assets/icons/edit-icon.png') }}" class="w-4">
                                        </button>

                                        {{-- DELETE --}}
                                        <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            <button
                                                type="button"
                                                @click="kamarStatus = 'kosong'; openModal('confirm-delete')"
                                                class="p-2 rounded-md hover:bg-red-50 transition">
                                                <img src="{{ asset('assets/icons/delete-icon.png') }}" class="w-4">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr x-show="activeTab === 'kosong'">
                                <td colspan="6" class="py-8 text-center text-gray-500 text-sm">
                                    Tidak ada data kamar kosong.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </template>

                @if($allKamars->isEmpty())
                    <tbody>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 text-sm">
                                Belum ada data kamar terdaftar.
                            </td>
                        </tr>
                    </tbody>
                @endif

            </table>

        </div>

    </div>


    {{-- ================= PAGINATION ================= --}}
    <x-pagination />


    {{-- ================= MODAL ================= --}}
    <x-modal show="modalOpen" maxWidth="lg:max-w-[550px] max-w-[360px]">

        {{-- ================= TAMBAH KAMAR ================= --}}
        <template x-if="modalType === 'tambah-kamar'">

            <div class="relative">

                <button
                    type="button"
                    @click="closeModal()"
                    class="absolute top-0 right-0 text-xl">

                    ✕

                </button>

                <h2 class="text-xl font-bold mb-6">
                    Tambah Kamar
                </h2>

                <div class="space-y-4">
                        <form action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                            <x-form.input
                                label="Nomor Kamar"
                                name="nomor_kamar"
                                placeholder="Contoh: KM001" class="text-sm" />

                            <x-form.select
                                label="Tipe Kamar"
                                name="tipe_kamar"
                                placeholder="Pilih tipe kamar" class="text-sm">
                                <option value="standard" class="text-xs">Standard</option>
                                <option value="premium" class="text-xs">Premium</option>

                            </x-form.select>

                            <x-form.input
                                label="Harga per Bulan"
                                name="harga"
                                placeholder="Contoh: Rp500.000" class="text-sm" />

                            <x-form.input
                                label="Fasilitas Kamar"
                                name="fasilitas"
                                placeholder="Contoh: Lemari, WiFi, dll" class="text-sm" />

                        <div class="flex gap-3 pt-4">

                            <x-form.button
                                type="button"
                                class="w-full bg-transparent border-2 border-primary !text-primary hover:bg-secondary hover:border-secondary hover:!text-primary"
                                @click="closeModal()">
                                Batal
                            </x-form.button>

                            <x-form.button
                                type="submit"
                                class="w-full">
                                Simpan
                            </x-form.button>

                        </form>
                    </div>
                </div>

            </div>

        </template>


        {{-- ================= DETAIL KAMAR ================= --}}
        <template x-if="modalType === 'detail-kamar'">

            <div class="relative">

                {{-- CLOSE --}}
                <button
                    type="button"
                    @click="closeModal()"
                    class="absolute top-0 right-0 text-xl">

                    ✕

                </button>

                {{-- TITLE --}}
                <h2 class="text-xl font-bold mb-6">
                    Detail Kamar
                </h2>

                {{-- CONTENT --}}
                <div class="space-y-4 lg:max-h-[450px] max-h-[250px] overflow-auto">

                    <x-form.input
                        label="Nomor Kamar"
                        name="detail-nomor-kamar"
                        x-model="detailKamarNomor"
                        class="lg:text-sm text-xs"
                        readonly />

                    <x-form.input
                        label="Nama Penghuni"
                        name="detail-penghuni"
                        x-model="detailKamarPenghuni"
                        class="lg:text-sm text-xs"
                        readonly />

                    <x-form.select
                        label="Tipe Kamar"
                        name="detail-tipe"
                        class="lg:text-sm text-xs"
                        disabled>

                        <option x-text="detailKamarTipe"></option>

                    </x-form.select>

                    <x-form.select
                        label="Status Kamar"
                        name="detail-status"
                        x-model="detailKamarStatus"
                        class="lg:text-sm text-xs"
                        disabled>

                        <option value="kosong" x-text="detailKamarStatus === 'kosong' ? 'Kosong' : ''"></option>
                        <option value="terisi" x-text="detailKamarStatus === 'terisi' ? 'Terisi' : ''"></option>

                    </x-form.select>

                    <x-form.input
                        label="Harga per Bulan"
                        name="detail-harga"
                        x-model="detailKamarHarga"
                        class="lg:text-sm text-xs"
                        readonly />

                    <x-form.input
                        label="Fasilitas Kamar"
                        name="detail-fasilitas"
                        x-model="detailKamarFasilitas"
                        class="lg:text-sm text-xs"
                        readonly />
                </div>
            </div>

        </template>


        {{-- ================= EDIT KAMAR ================= --}}
        <template x-if="modalType === 'edit-kamar'">

            <div class="relative">

                {{-- CLOSE --}}
                <button
                    type="button"
                    @click="closeModal()"
                    class="absolute top-0 right-0 text-xl">

                    ✕

                </button>

                {{-- TITLE --}}
                <h2 class="text-xl font-bold mb-6">
                    Edit Kamar
                </h2>

                {{-- CONTENT --}}
                <div class="space-y-4 lg:max-h-[450px] max-h-[250px] overflow-auto">

                    <x-form.input
                        label="Nomor Kamar"
                        name="nomor_kamar"
                        value="KM001"
                        class="lg:text-sm text-xs" />

                    <x-form.input
                        label="Nama Penghuni"
                        name="edit-penghuni"
                        ::value="kamarStatus === 'kosong' ? '-' : 'Anton Subagja'"
                        class="lg:text-sm text-xs" />

                    <x-form.select
                        label="Tipe Kamar"
                        name="edit-tipe"
                        class="lg:text-sm text-xs">

                        <option selected>
                            Standard
                        </option>

                        <option>
                            Premium
                        </option>

                    </x-form.select>

                    <x-form.select
                        label="Status Kamar"
                        name="edit-status"
                        x-model="kamarStatus"
                        class="lg:text-sm text-xs">

                        <option value="kosong">
                            Kosong
                        </option>

                        <option value="terisi">
                            Terisi
                        </option>

                    </x-form.select>

                    <x-form.input
                        label="Harga per Bulan"
                        name="edit-harga"
                        value="Rp500.000"
                        class="lg:text-sm text-xs" />

                    <x-form.input
                        label="Fasilitas Kamar"
                        name="edit-fasilitas"
                        value="Lemari, WiFi"
                        class="lg:text-sm text-xs" />

                </div>
                {{-- ACTION --}}
                <div class="flex gap-3 pt-4">

                    <x-form.button
                        type="button"
                        class="
                    w-full
                    bg-transparent
                    border-2
                    border-primary
                    !text-primary
                    hover:bg-secondary
                    hover:border-secondary
                    hover:!text-primary
                "
                        @click="closeModal()">

                        Batal

                    </x-form.button>

                    <x-form.button
                        type="button"
                        class="w-full"
                        @click="showSuccess('Data kamar berhasil diperbarui')">

                        Simpan

                    </x-form.button>

                </div>
            </div>


        </template>


        {{-- ================= CONFIRM DELETE ================= --}}
        <template x-if="modalType === 'confirm-delete'">

            <div class="relative">

                <button
                    type="button"
                    @click="closeModal()"
                    class="absolute top-0 right-0 text-xl">

                    ✕

                </button>

                <h2 class="text-xl font-bold mb-4">
                    Konfirmasi Hapus
                </h2>

                <p class="text-sm text-neutral">
                    Apakah Anda yakin ingin menghapus kamar? Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="flex gap-3 mt-8">

                    <x-form.button
                        type="button"
                        class="w-full bg-transparent border-2 border-neutral !text-neutral hover:bg-neutral hover:!text-white"
                        @click="closeModal()">
                        Batal
                    </x-form.button>

                    <x-form.button
                        type="button"
                        class="w-full bg-red-600 hover:bg-red-100 hover:text-red-600"
                        @click="document.querySelector('.delete-form')?.submit()">
                        Hapus
                    </x-form.button>

                </div>

            </div>

        </template>


        {{-- ================= CANNOT DELETE ================= --}}
        <template x-if="modalType === 'cannot-delete'">

            <div class="relative lg:px-2 px-1 pt-2 pb-1">

                {{-- CLOSE BUTTON --}}
                <button
                    type="button"
                    @click="closeModal()"
                    class="
                absolute
                top-0
                right-0
                w-8 h-8
                flex items-center justify-center
                rounded-full
                hover:bg-gray-100
                transition
            ">
                    ✕
                </button>

                {{-- CONTENT --}}
                <div class="text-center pt-6">

                    <h2 class="lg:text-lg text-sm font-bold mb-3 pr-6 text-red-600">
                        Tidak dapat menghapus kamar
                    </h2>

                    <p class="lg:text-sm text-xs text-neutral leading-relaxed">
                        Anda tidak dapat menghapus kamar
                        yang masih ada penghuninya.
                    </p>

                </div>

            </div>

        </template>


        {{-- ================= SUCCESS ================= --}}
        <template x-if="modalType === 'success'">

            <div class="text-center">

                <div class="flex justify-center mb-4">

                    <img
                        src="{{ asset('assets/icons/success-modal-icon.png') }}"
                        class="w-14">

                </div>

                <h2 class="text-lg font-bold">
                    <span x-text="successMessage"></span>
                </h2>

            </div>

        </template>

    </x-modal>

</div>
@endsection
