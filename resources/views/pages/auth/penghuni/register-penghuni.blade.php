@extends('layouts.app')
@section('title', 'Register Penghuni')
@section('content')

<div
    x-data="{
        errors: {
            nama: '{{ addslashes($errors->first('nama')) }}',
            telpon: '{{ addslashes($errors->first('telpon')) }}',
            alamat: '{{ addslashes($errors->first('alamat')) }}',
            email: '{{ addslashes($errors->first('email')) }}',
            password: '{{ addslashes($errors->first('password')) }}',
        },
        validate() {
            this.errors = {};

            const nama = document.querySelector('[name=nama]').value.trim();
            if (!nama) {
                this.errors.nama = 'Nama wajib diisi.';
            } else if (nama.length < 3) {
                this.errors.nama = 'Nama minimal 3 karakter.';
            } else if (nama.length > 100) {
                this.errors.nama = 'Nama maksimal 100 karakter.';
            }

            const telpon = document.querySelector('[name=telpon]').value.trim();
            if (!telpon) {
                this.errors.telpon = 'Nomor telepon wajib diisi.';
            } else if (!/^\d+$/.test(telpon)) {
                this.errors.telpon = 'Nomor telepon harus berupa angka.';
            } else if (telpon.length < 11 || telpon.length > 15) {
                this.errors.telpon = 'Nomor telepon harus 11-15 digit.';
            }

            const alamat = document.querySelector('[name=alamat]').value.trim();
            if (!alamat) {
                this.errors.alamat = 'Alamat wajib diisi.';
            } else if (alamat.length < 10) {
                this.errors.alamat = 'Alamat minimal 10 karakter.';
            } else if (alamat.length > 255) {
                this.errors.alamat = 'Alamat maksimal 255 karakter.';
            }

            const email = document.querySelector('[name=email]').value.trim();
            if (!email) {
                this.errors.email = 'Email wajib diisi.';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                this.errors.email = 'Format email tidak valid.';
            } else if (email.length > 100) {
                this.errors.email = 'Email maksimal 100 karakter.';
            }

            const password = document.querySelector('[name=password]').value;
            if (!password) {
                this.errors.password = 'Password wajib diisi.';
            } else if (password.length < 8) {
                this.errors.password = 'Password minimal 8 karakter.';
            } else if (password.length > 32) {
                this.errors.password = 'Password maksimal 32 karakter.';
            }

            return Object.keys(this.errors).length === 0;
        }
    }"
    class="lg:p-14 p-8 w-full min-h-screen bg-cover bg-center bg-no-repeat"
    style="background-image: url('../assets/images/bg-auth.png');">

    <div class="flex lg:flex-row flex-col lg:gap-12 gap-8">

        {{-- LEFT SIDE --}}
        <div class="w-full">
            <div class="flex flex-col justify-start items-start">
                <img src="{{ asset('assets/images/logo-auth.png') }}" alt="logo" class="mb-4" width="150px">
                <h1 class="text-primary md:text-4xl text-xl font-bold mb-4">Selamat Datang di Kostku</h1>
                <p class="text-black md:text-lg text-sm">Semua kebutuhan pengelolaan kos dalam satu sistem yang praktis dan terorganisir.</p>
            </div>
            <div class="flex justify-center items-center">
                <img src="{{ asset('assets/icons/login-penghuni-icon.png') }}" alt="Login Penghuni" width="420px" class="lg:block hidden">
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="w-full flex justify-center">
            <x-card class="w-[500px]">
                <h1 class="lg:text-3xl text-xl text-black font-bold mb-4">Daftar Penghuni</h1>
                <p class="text-neutral text-sm mb-6">Buat akun untuk mengelola aktivitas Anda.</p>

                <form action="{{ route('penghuni.store') }}" method="POST">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-4">
                        <x-form.input label="Nama Lengkap" name="nama" placeholder="Masukkan nama lengkap" :value="old('nama')" />
                        <p x-show="errors.nama" x-text="errors.nama" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    {{-- Telepon --}}
                    <div class="mb-4">
                        <x-form.input label="Nomor Telepon" name="telpon" placeholder="08xxxxxxxxxx" :value="old('telpon')" />
                        <p x-show="errors.telpon" x-text="errors.telpon" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-4">
                        <x-form.input label="Alamat" name="alamat" placeholder="Masukkan alamat Anda" :value="old('alamat')" />
                        <p x-show="errors.alamat" x-text="errors.alamat" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <x-form.input label="Email" name="email" type="email" placeholder="contoh@gmail.com" :value="old('email')" />
                        <p x-show="errors.email" x-text="errors.email" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <x-form.input label="Password" name="password" type="password" placeholder="Masukkan password" class="pr-10" />
                        <p x-show="errors.password" x-text="errors.password" class="text-red-500 text-xs mt-1"></p>
                    </div>

                    <x-form.button
                        type="button"
                        class="w-full my-4"
                        @click="if(validate()) $el.closest('form').submit()">
                        Daftar
                    </x-form.button>

                    <div class="flex justify-center">
                        <p class="md:text-md text-sm text-[#686868]">Sudah punya akun?
                            <span class="text-primary font-semibold">
                                <a href="{{ route('login') }}"> Login</a>
                            </span>
                        </p>
                    </div>

                </form>
            </x-card>
        </div>

    </div>
</div>

@endsection