@extends('layouts.app')
@section('title', 'Login Penghuni')
@section('content')
<div class="lg:p-14 p-8 w-full min-h-screen bg-cover bg-center bg-no-repeat " style="background-image: url('../assets/images/bg-auth.png');">
    <img src="{{ asset('assets/images/logo-auth.png') }}" alt="logo" class="mb-4" width="150px">
    <div class="flex lg:flex-row flex-col lg:gap-12 gap-8">
        <div class="w-full">
            <div class="flex flex-col justify-start items-start">
                <h1 class="text-primary md:text-4xl text-xl font-bold mb-4">Selamat Datang di Kostku</h1>
                <p class="text-black md:text-lg text-sm">Semua kebutuhan pengelolaan kos dalam satu sistem yang praktis dan terorganisir.</p>
            </div>
            <div class="flex justify-center items-center">
                <img src="{{ asset('assets/icons/login-penghuni-icon.png') }}" alt="Login Penghuni" width="420px" class="lg:block hidden">
            </div>
        </div>
        <div class="w-full">
            <div class="flex justify-center lg:pt-10 pt-2">
                <x-card class="w-[500px]">
                    <h1 class="lg:text-3xl text-xl text-black font-bold mb-4">Login Penghuni</h1>
                    <p class="text-neutral text-sm mb-6">Masuk ke akun Anda</p>
                    <form action="{{ route('penghuni.sessionLogin') }}" method="POST">
                        @csrf
                        <div>
                            <x-form.input
                                label="Email"
                                name="email"
                                type="email"
                                placeholder="contoh@gmail.com" />
                        </div>
                        <div class="mt-4"><x-form.input
                                label="Password"
                                name="password"
                                type="password"
                                placeholder="Masukkan password " /></div>
                        <x-form.button type="submit" class="my-8">Login</x-form.button>
                    </form>
                    <div class="flex justify-center">
                        <p class="md:text-md text-sm text-[#686868]">Belum punya akun?<span class="text-primary font-semibold"><a href="{{ route('register.penghuni') }}"> Daftar</a></span></p>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
</div>
@endsection
