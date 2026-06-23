@extends('layouts.app')
@section('title', 'Register Penghuni')

@section('content')

<div
    x-data="{
        step: {{ $errors->hasAny(['nama_kost','alamat_kost','sertifikat']) && !$errors->hasAny(['nama','telpon','email','password','alamat']) ? 2 : 1 }},
        open: false,
        status: null,
        errors: {
            nama: '{{ addslashes($errors->first('nama')) }}',
            telpon: '{{ addslashes($errors->first('telpon')) }}',
            email: '{{ addslashes($errors->first('email')) }}',
            password: '{{ addslashes($errors->first('password')) }}',
            alamat: '{{ addslashes($errors->first('alamat')) }}',
        },
        step2Errors: {},
        validateStep1() {
            this.errors = {};
            const nama = document.querySelector('[name=nama]').value.trim();
            if (!nama)
            {
                this.errors.nama = 'Nama wajib diisi.';
            }
            else if (nama.length < 3)
            {
                this.errors.nama = 'Nama minimal 3 karakter.';
            }
            else if (nama.length > 100)
            {
                this.errors.nama = 'Nama maksimal 100 karakter.';
            }
            const telpon = document.querySelector('[name=telpon]').value.trim();
            if (!telpon)
            {
                this.errors.telpon = 'Nomor telepon wajib diisi.';
            }
            else if (!/^\d+$/.test(telpon))
            {
                this.errors.telpon = 'Nomor telepon harus berupa angka.';
            }
            else if (telpon.length < 11 || telpon.length > 15)
            {
                this.errors.telpon = 'Nomor telepon harus 11-15 digit.';
            }
            const email = document.querySelector('[name=email]').value.trim();
            if (!email)
            {
                this.errors.email = 'Email wajib diisi.';
            }
            else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
            {
                this.errors.email = 'Format email tidak valid.';
            }
            else if (email.length > 100)
            {
                this.errors.email = 'Email maksimal 100 karakter.';
            }
            const password = document.querySelector('[name=password]').value;
            if (!password)
            {
                this.errors.password = 'Password wajib diisi.';
            }
            else if (password.length < 8)
            {
                this.errors.password = 'Password minimal 8 karakter.';
            }
            else if (password.length > 32)
            {
                this.errors.password = 'Password maksimal 32 karakter.';
            }
            const alamat = document.querySelector('[name=alamat]').value.trim();
            if (!alamat)
            {
                this.errors.alamat = 'Alamat wajib diisi.';
            }
            else if (alamat.length < 10)
            {
                this.errors.alamat = 'Alamat minimal 10 karakter.';
            }
            else if (alamat.length > 255)
            {
                this.errors.alamat = 'Alamat maksimal 255 karakter.';
            }
            return Object.keys(this.errors).length === 0; // ← tambahkan ini

        },
        validateStep2()
        {
            this.step2Errors = {};

            const namaKost =
                document.querySelector('[name=nama_kost]').value.trim();

            const alamatKost =
                document.querySelector('[name=alamat_kost]').value.trim();

            const sertifikat = document.querySelector('input[name=sertifikat]').files[0];

            if (!namaKost)
            {
                this.step2Errors.nama_kost =
                    'Nama kost wajib diisi.';
            }
            else if (namaKost.length < 3)
            {
                this.step2Errors.nama_kost =
                    'Nama kost minimal 3 karakter.';
            }
            else if (namaKost.length > 100)
            {
                this.step2Errors.nama_kost =
                    'Nama kost maksimal 100 karakter.';
            }

            if (!alamatKost)
            {
                this.step2Errors.alamat_kost =
                    'Alamat kost wajib diisi.';
            }
            else if (alamatKost.length < 10)
            {
                this.step2Errors.alamat_kost =
                    'Alamat kost minimal 10 karakter.';
            }
            else if (alamatKost.length > 255)
            {
                this.step2Errors.alamat_kost =
                    'Alamat kost maksimal 255 karakter.';
            }

            if (!sertifikat)
            {
                this.step2Errors.sertifikat =
                    'Sertifikat wajib diunggah.';
            }
            else if (
                sertifikat.type !== 'application/pdf'
            )
            {
                this.step2Errors.sertifikat =
                    'File harus PDF.';
            }
            else if (
                sertifikat.size > 10485760
            )
            {
                this.step2Errors.sertifikat =
                    'Ukuran file maksimal 10 MB.';
            }

            return Object.keys(this.step2Errors).length === 0;
        }
    }"

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

                    <form action="{{ route('pengelola.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- STEP 1 --}}
                        <div x-show="step === 1" x-transition style="display: block">

                            <h1 class="lg:text-3xl text-xl font-bold mb-4">Daftar Pengelola</h1>
                            <p class="text-neutral text-sm mb-6">Buat akun untuk mengelola aktivitas Anda.</p>

                            {{-- Nama --}}
                            <div class="mb-4">
                                <x-form.input label="Nama Pengelola" name="nama" placeholder="Masukkan nama lengkap" :value="old('nama')" />
                                <p x-show="errors.nama" x-text="errors.nama" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Telepon --}}
                            <div class="mb-4">
                                <x-form.input label="Nomor telepon" name="telpon" placeholder="08xxxxxxxxxx" :value="old('telpon')" />
                                <p x-show="errors.telpon" x-text="errors.telpon" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <x-form.input label="Email" name="email" type="email" placeholder="contoh@gmail.com" :value="old('email')" />
                                <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Password --}}
                            <div class="mb-4">
                                <x-form.input label="Password" name="password" placeholder="Masukkan password" type="password" class="pr-10" />
                                <p x-show="errors.password" x-text="errors.password" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <x-form.input label="Alamat" name="alamat" placeholder="Masukkan alamat lengkap" :value="old('alamat')" />
                                <p x-show="errors.alamat" x-text="errors.alamat" class="text-red-500 text-xs mt-1"></p>
                            </div>

                            <x-form.button type="button" class="w-full my-4" @click="if(validateStep1()) step = 2">
                                Lanjut
                            </x-form.button>
                            <div class="flex justify-center">
                                <p class="md:text-md text-sm text-[#686868]">Sudah punya akun?<span class="text-primary font-semibold"><a href="{{ route('login') }}"> Login</a></span></p>
                            </div>
                        </div>

                        {{-- STEP 2 --}}
                        <div x-show="step === 2" x-transition style="display: block">

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

                            {{-- Nama Kost --}}
                            <div class="mb-4">
                                <x-form.input label="Nama Kost" name="nama_kost" placeholder="Masukkan nama kost" :value="old('nama_kost')" />
                                @error('nama_kost')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p
                                    x-show="step2Errors.nama_kost"
                                    x-text="step2Errors.nama_kost"
                                    class="text-red-500 text-xs mt-1">
                                </p>
                            </div>

                            {{-- Alamat Kost --}}
                            <div class="mb-4">
                                <x-form.input label="Alamat Kost" name="alamat_kost" placeholder="Masukkan alamat kost" :value="old('alamat_kost')" />
                                @error('alamat_kost')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p
                                    x-show="step2Errors.alamat_kost"
                                    x-text="step2Errors.alamat_kost"
                                    class="text-red-500 text-xs mt-1">
                                </p>
                            </div>

                            {{-- FILE UPLOAD --}}
                            <div x-data="{
                                file: null,
                                fileSize: '',
                                handleFile(event) {
                                    this.file = event.target.files[0];
                                    this.fileSize = (this.file.size / 1024 / 1024).toFixed(2) + ' MB';
                                },
                                removeFile() {
                                    this.file = null;
                                    this.fileSize = '';
                                }
                            }" class="w-full mb-1">

                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Sertifikat/Kepemilikan Tanah (Wajib)
                                </label>

                                {{-- ================= BEFORE UPLOAD ================= --}}
                                <div x-show="!file">

                                    <div
                                        class="border-2 border-dashed {{ $errors->has('sertifikat') ? 'border-red-400' : 'border-gray-300' }} rounded-xl h-32 cursor-pointer hover:border-primary transition flex items-center justify-center"
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
                                    name="sertifikat"
                                    accept=".pdf"
                                    class="hidden"
                                    x-ref="file"
                                    @change="handleFile($event)">
                            </div>

                            <p
                                x-show="step2Errors.sertifikat"
                                x-text="step2Errors.sertifikat"
                                class="text-red-500 text-xs mt-1">
                            </p>

                            @error('sertifikat')
                            <p class="text-red-500 text-xs mt-1 mb-2">{{ $message }}</p>
                            @else
                            <p class="text-neutral text-xs mb-4">Dokumen ini digunakan untuk verifikasi kepemilikan kost</p>
                            @enderror


                            <x-form.button
                                type="button"
                                class="w-full my-4"
                                @click="if(validateStep2()){$el.closest('form').submit()}">
                                Daftar
                            </x-form.button>
                            <div class="flex justify-center">
                                <p class="md:text-md text-sm text-[#686868]">Sudah punya akun?<span class="text-primary font-semibold"><a href="{{ route('login') }}"> Login</a></span></p>
                            </div>
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

                            <div class="shadow-md px-8 py-10 w-18 h-20 bg-[#FEF5B2] flex items-center justify-center rounded-2xl">
                                <img src="{{ asset('assets/icons/pending-icon.png') }}" class="w-7">
                            </div>

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

                <a href="{{ route('login') }}" class="block w-full text-center bg-primary text-white rounded-lg py-2 text-sm font-medium mt-4 hover:opacity-90">
                    Kembali ke Login
                </a>

            </x-modal>

            <!-- modal akun disetujui -->
            <!-- <x-modal show="true" maxWidth="lg:max-w-[450px] max-w-xs">

                <x-slot name="header">
                    <template x-if="status === 'verified'">
                        <div class="flex flex-col items-center">

                            <div class="shadow-md px-8 py-10 w-18 h-20 bg-[#FEF5B2] flex items-center justify-center rounded-2xl">
                                <img src="{{ asset('assets/icons/verified-icon.png') }}" class="w-10">
                            </div>

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

    @if(session('registered'))
    <script>
        window.addEventListener('load', () => {
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'pending'
            }));
        });
    </script>
    @endif


    @endsection