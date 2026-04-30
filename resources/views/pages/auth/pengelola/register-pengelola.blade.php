@extends('layouts.app')
@section('title', 'Register Penghuni')
@section('content')
<div class="lg:p-14 p-8 w-full min-h-screen bg-cover bg-center bg-no-repeat " style="background-image: url('../assets/images/bg-auth.png');">
    <div class="flex lg:flex-row flex-col lg:gap-12 gap-8">
        <div class="w-full">
            <div class="flex flex-col justify-start items-start">
                <img src="{{ asset('assets/images/logo-auth.png') }}" alt="logo" class="mb-4" width="150px">
                <h1 class="text-primary md:text-4xl text-xl font-bold mb-4">Kelola Kost Anda dengan Mudah</h1>
                <p class="text-black md:text-lg text-sm">Semua kebutuhan pengelolaan kos dalam satu sistem yang praktis dan terorganisir.</p>
            </div>
            <div class="flex justify-center items-center">
                <img src="{{ asset('assets/icons/login-pengelola-icon.png') }}" alt="Login Penghuni" width="420px" class="lg:block hidden">
            </div>
        </div>
        <div class="w-full flex justify-center">
            <x-card class="w-[500px]">
                <h1 class="lg:text-3xl text-xl text-black font-bold mb-4">Daftar Pengelola</h1>
                <p class="text-neutral text-sm mb-6">Buat akun untuk mengelola aktivitas Anda.</p>
                <form action="">
                    <div class="mb-4">
                        <x-form.input
                            label="Nama Pengelola"
                            name="nama"
                            type="text"
                            placeholder="Masukkan nama lengkap" />
                    </div>
                    <div class="mb-4">
                        <x-form.input
                            label="Username"
                            name="username"
                            type="text"
                            placeholder="Masukkan username" />
                    </div>
                    <div class="mb-4">
                        <x-form.input
                            label="Email"
                            name="email"
                            type="email"
                            placeholder="contoh@gmail.com" />
                    </div>
                    <div class="mb-4"><x-form.input
                            label="Password"
                            name="password"
                            type="password"
                            placeholder="Masukkan password " /></div>
                    <div>
                        <x-form.textarea
                            label="Alamat"
                            name="alamat-pengelola"
                            rows="4"
                            placeholder="Masukkan alamat Anda" />
                    </div>
                    <x-form.button class="my-8">Daftar</x-form.button>
                    <div class="flex justify-center">
                        <p class="md:text-md text-sm text-[#686868]">Sudah punya akun?<span class="text-primary font-semibold"><a href="{{ route('login.pengelola') }}"> Login</a></span></p>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>
@endsection