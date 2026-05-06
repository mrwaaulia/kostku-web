@extends('layouts.app')
@section('title', 'Lupa Password')

@section('content')

<div
    x-data="{ step: 1 }"
    class="lg:p-14 p-8 w-full min-h-screen bg-cover bg-center bg-no-repeat"
    style="background-image: url('../assets/images/bg-auth.png');">

    <img src="{{ asset('assets/images/logo-auth.png') }}" class="mb-4" width="150px">

    <div class="flex lg:flex-row flex-col lg:gap-12 gap-8">

        {{-- LEFT --}}
        <div class="w-full">
            <div class="flex flex-col">
                <h1 class="text-primary md:text-4xl text-xl font-bold mb-4">
                    Selamat Datang di Kostku
                </h1>
                <p class="text-black md:text-lg text-sm">
                    Semua kebutuhan pengelolaan kos dalam satu sistem yang praktis dan terorganisir.
                </p>
            </div>

            <div class="flex justify-center">
                <img src="{{ asset('assets/icons/login-penghuni-icon.png') }}" width="420px" class="lg:block hidden">
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="w-full flex justify-center lg:pt-10 pt-2">

            <x-card class="w-[500px] h-fit">

                <form action="" method="POST">
                    @csrf

                    {{-- ================= STEP 1 ================= --}}
                    <div x-show="step === 1" x-transition>

                        {{-- BACK TO LOGIN --}}
                        <a href="{{ route('login') }}" class="text-sm flex items-center gap-2 mb-4 text-[#313131]">
                            <span class="text-xl pb-1">
                                < </span>Kembali ke Login
                        </a>

                        <h1 class="lg:text-3xl text-xl font-bold mb-4">
                            Lupa Password
                        </h1>

                        <p class="text-neutral text-sm mb-6">
                            Masukkan email Anda untuk mendapatkan kode verifikasi
                        </p>

                        <x-form.input
                            label="Email"
                            name="email"
                            type="email"
                            placeholder="contoh@gmail.com" />

                        <x-form.button
                            type="button"
                            class="mt-8 w-full"
                            @click="step = 2">
                            Kirim Kode
                        </x-form.button>

                    </div>

                    {{-- ================= STEP 2 ================= --}}
                    <div x-show="step === 2" x-transition>

                        {{-- BACK --}}
                        <button type="button" @click="step = 1" class="text-sm flex items-center gap-2 mb-4">
                            <span class="text-xl pb-1">
                                < </span> Kembali
                        </button>

                        <h1 class="lg:text-3xl text-xl font-bold mb-4">
                            Kode Verifikasi
                        </h1>

                        <p class="text-neutral text-sm mb-6">
                            Masukkan kode verifikasi yang dikirimkan ke email Anda
                        </p>

                        <x-form.input
                            label="Kode Verifikasi"
                            name="kode"
                            placeholder="Masukkan kode verifikasi" />

                        <p class="text-xs text-gray-500 mt-3">
                            Tidak menerima kode?
                            <button type="button" class="text-[#FE4332] font-medium">
                                Kirim Ulang
                            </button>
                        </p>

                        <x-form.button
                            type="button"
                            class="mt-8 w-full"
                            @click="step = 3">
                            Verifikasi
                        </x-form.button>

                    </div>

                    {{-- ================= STEP 3 ================= --}}
                    <div x-show="step === 3" x-transition>

                        {{-- BACK --}}
                        <button type="button" @click="step = 2" class="text-sm flex items-center gap-2 mb-4">
                            <span class="text-xl pb-1">
                                < </span> Kembali
                        </button>

                        <h1 class="lg:text-3xl text-xl font-bold mb-4">
                            Reset Password
                        </h1>

                        <p class="text-neutral text-sm mb-6">
                            Masukkan password baru Anda
                        </p>

                        <div class="mb-4"><x-form.input
                                label="Password Baru"
                                name="password"
                                type="password"
                                placeholder="Masukkan password baru" /></div>

                        <div class="mb-4"><x-form.input
                                label="Konfirmasi Password"
                                name="password-confirmation"
                                type="password"
                                placeholder="Ulangi password" /></div>

                        <x-form.button
                            type="submit"
                            class="mt-4 w-full">
                            Perbarui Password
                        </x-form.button>

                    </div>

                </form>

            </x-card>

        </div>

    </div>

</div>

@endsection