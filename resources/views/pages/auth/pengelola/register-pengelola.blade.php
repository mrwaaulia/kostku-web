@extends('layouts.app')
@section('title', 'Register Penghuni')

@section('content')

<div
    x-data="{ step: 1, open: false, status: null }"
    @open-modal.window="open = true; status = $event.detail"
    class="relative min-h-screen">

    {{-- ================= BACKGROUND ================= --}}
    <div
        class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('../assets/images/bg-auth.png');">
    </div>

    {{-- ================= CONTENT ================= --}}
    <div x-show="!open"
        class="relative z-10 lg:p-14 p-8">

        <div class="flex lg:flex-row flex-col lg:gap-12 gap-8">

            {{-- LEFT SIDE --}}
            <div class="w-full">
                <div class="flex flex-col justify-start items-start">
                    <img src="{{ asset('assets/images/logo-auth.png') }}" class="mb-4" width="150">
                    <h1 class="text-primary md:text-4xl text-xl font-bold mb-4">
                        Kelola Kost Anda dengan Mudah
                    </h1>
                    <p class="text-black md:text-lg text-sm">
                        Semua kebutuhan pengelolaan kos dalam satu sistem yang praktis dan terorganisir.
                    </p>
                </div>

                <div class="flex justify-center items-center">
                    <img src="{{ asset('assets/icons/login-pengelola-icon.png') }}" width="420" class="lg:block hidden">
                </div>
            </div>

            {{-- RIGHT SIDE --}}
            <div class="w-full flex justify-center">

                <x-card class="lg:w-[500px] w-full">

                    <form action="{{ route('register.pengelola') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- STEP 1 --}}
                        <div x-show="step === 1" x-transition>

                            <h1 class="lg:text-3xl text-xl font-bold mb-4">Daftar Pengelola</h1>
                            <p class="text-neutral text-sm mb-6">Buat akun untuk mengelola aktivitas Anda.</p>

                            <x-form.input label="Nama Pengelola" name="nama" placeholder="Masukkan nama lengkap" placeholder="Masukkan nama lengkap" class="mb-4" />
                            <x-form.input label="Nomor telepon" name="telepon" placeholder="08xxxxxxxxxx" class="mb-4" />
                            <x-form.input label="Email" name="email" type="email" placeholder="contoh@gmail.com" class="mb-4" />
                            <x-form.input label="Password" name="password" placeholder="Masukkan password" type="password" />

                            <x-form.button type="button" class="w-full mt-8" @click="step = 2">
                                Lanjut
                            </x-form.button>
                        </div>

                        {{-- STEP 2 --}}
                        <div x-show="step === 2" x-transition>

                            {{-- Back Button --}}
                            <button
                                type="button"
                                @click="step = 1"
                                class="text-sm text-[#313131] flex items-center gap-2">
                                <span class="text-2xl pb-1 text-[#313131]">
                                    < </span>
                                        Kembali ke daftar
                            </button>


                            <h1 class="lg:text-3xl text-xl font-bold mb-4">Daftar Kost</h1>

                            <x-form.input label="Nama Kost" name="nama-kost" placeholder="Masukkan nama kost" class="mb-4" />
                            <x-form.input label="Alamat Kost" name="alamat-kost" placeholder="Masukkan alamat kost" class="mb-4" />

                            {{-- FILE UPLOAD --}}
                            <div x-data="fileUpload()" class="w-full mb-1">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Sertifikat/Kepemilikan Tanah (Wajib)
                                </label>

                                {{-- ================= BEFORE UPLOAD ================= --}}
                                <div x-show="!file">

                                    <div
                                        class="border-2 border-dashed border-gray-300 rounded-xl h-32 cursor-pointer hover:border-primary transition flex items-center justify-center"
                                        @click="$refs.file.click()">

                                        <div class="flex flex-col items-center justify-center text-body lg:p-2 p-6">

                                            <img src="{{ asset('assets/icons/cloud-add.png') }}" class="w-8 h-8 lg:mb-4 mb-2">

                                            <p class="lg:text-sm text-xs text-center mb-1">Drag & drop file atau klik untuk upload</p>

                                            <p class="lg:text-xs text-[10px] text-[#B0B0B0]">Format: PDF (Max 10MB)</p>

                                        </div>

                                    </div>

                                </div>

                                {{-- ================= AFTER UPLOAD ================= --}}
                                <div x-show="file" x-transition class="w-full">

                                    <x-card class="relative flex items-center gap-3 w-full h-14 overflow-hidden bg-[#F8F8F8]">

                                        {{-- DELETE --}}
                                        <button
                                            type="button"
                                            class="absolute top-2 right-2"
                                            @click="removeFile(); $refs.file.value = null">
                                            <img src="{{ asset('assets/icons/delete-icon.png') }}" class="w-4">
                                        </button>

                                        {{-- ICON --}}
                                        <img src="{{ asset('assets/icons/pdf-icon.png') }}" class="w-10 h-10 shrink-0">

                                        {{-- INFO --}}
                                        <div class="flex-1 min-w-0 pr-6">

                                            {{-- FILE NAME --}}
                                            <p class="text-sm font-medium truncate w-full">
                                                <span x-text="file.name"></span>
                                            </p>

                                            {{-- META --}}
                                            <div class="flex items-center gap-2 mt-1 text-xs flex-wrap">

                                                <span class="text-gray-500 whitespace-nowrap"
                                                    x-text="fileSize + ' of ' + fileSize + ' •'">
                                                </span>

                                                <span class="text-black flex items-center gap-1 whitespace-nowrap">
                                                    <img src="{{ asset('assets/icons/success-icon.png') }}" class="w-3 h-3">
                                                    Selesai
                                                </span>

                                            </div>

                                        </div>

                                    </x-card>

                                </div>

                                {{-- INPUT (DI LUAR BOX) --}}
                                <input
                                    type="file"
                                    name="bukti"
                                    accept=".pdf"
                                    class="hidden"
                                    x-ref="file"
                                    @change="handleFile">

                            </div>
                            <p class="text-neutral text-xs mb-4">Dokumen ini digunakan untuk verifikasi kepemilikan kost</p>

                            <x-form.button
                                type="button"
                                class="w-full mt-4"
                                @click="$dispatch('open-modal', 'pending')">
                                Daftar
                            </x-form.button>

                        </div>

                    </form>

                </x-card>

            </div>

        </div>

    </div>


    {{-- ================= MODAL ================= --}}
    <div x-show="open"
        class="fixed inset-0 flex items-center justify-center z-50">

        <div x-show="open">

            <x-modal show="true" maxWidth="lg:max-w-[450px] max-w-xs">

                <x-slot name="header">
                    <template x-if="status === 'pending'">
                        <div class="flex flex-col items-center">

                            <x-card class="w-18 h-20 bg-[#FEF5B2] flex items-center justify-center rounded-2xl">
                                <img src="{{ asset('assets/icons/pending-icon.png') }}" class="w-7">
                            </x-card>

                            <x-badge type="warning" class="my-4">
                                Menunggu Verifikasi
                            </x-badge>

                            <h2 class="font-bold">Sedang Diproses</h2>
                        </div>
                    </template>
                </x-slot>

                <div class="text-center text-sm">
                    Akun Anda sedang diperiksa oleh admin (max 3 hari)
                </div>

            </x-modal>

            <!-- modal akun disetujui -->
            <!-- <x-modal show="true" maxWidth="lg:max-w-[450px] max-w-xs">

                <x-slot name="header">
                    <template x-if="status === 'verified'">
                        <div class="flex flex-col items-center">

                            <x-card class="w-18 h-20 bg-[#CFEFC7] flex items-center justify-center rounded-2xl">
                                <img src="{{ asset('assets/icons/verified-icon.png') }}" class="w-10">
                            </x-card>

                            <x-badge type="success" class="my-4">
                                Akun Disetujui
                            </x-badge>

                            <h2 class="font-bold">Selamat akun Anda sudah aktif.</h2>
                        </div>
                    </template>
                </x-slot>

                <div class="text-center text-sm">
                    Mengarahkan ke dashboard...
                </div>

            </x-modal> -->

        </div>

    </div>

    @endsection