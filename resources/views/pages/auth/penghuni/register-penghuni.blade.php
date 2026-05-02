@extends('layouts.app')
@section('title', 'Register Penghuni')
@section('content')
<div class="lg:p-14 p-8 w-full min-h-screen bg-cover bg-center bg-no-repeat " style="background-image: url('../assets/images/bg-auth.png');">
    <div class="flex lg:flex-row flex-col lg:gap-12 gap-8">
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
        <div class="w-full flex justify-center">
            <x-card class="w-[500px]">
                <h1 class="lg:text-3xl text-xl text-black font-bold mb-4">Daftar Penghuni</h1>
                <p class="text-neutral text-sm mb-6">Buat akun untuk mengelola aktivitas Anda.</p>
                <form action="{{ route('penghuni.store') }}" method="POST">
                    @csrf
                    {{-- @dd($user) --}}
                    <div>
                        <div class="mb-4">
                            <x-form.input
                            label="Nama Lengkap"
                            name="nama"
                            type="text"
                            placeholder="Masukkan nama lengkap" />
                            @error('nama')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <x-form.input
                        label="Nomor Telepon"
                        name="telpon"
                        type="text"
                        placeholder="08xxxxxxxxxx" />
                        <div class="mb-4">
                        {{-- @error('telpon')
                            <div>{{ $message }}</div>
                        @enderror --}}
                        </div>
                        <div class="mb-4">
                            <x-form.input
                            label="Alamat"
                            name="alamat"
                            type="text"
                            placeholder="Masukkan alamat Anda" />
                            @error('alamat')
                            <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <x-form.input
                            label="Email"
                            name="email"
                            type="email"
                            placeholder="contoh@gmail.com" />
                            @error('email')
                                <div>{{ $message }}</div>
                                @enderror
                            </div>
                        <div>
                            <x-form.input
                            label="Password"
                            name="password"
                            type="password"
                            placeholder="Masukkan password " />
                            @error('password')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <x-form.button type="submit" class="my-8">Daftar</x-form.button>
                        <div class="flex justify-center">
                            <p class="md:text-md text-sm text-[#686868]">Sudah punya akun?<span class="text-primary font-semibold"><a href="{{ route('login.penghuni') }}"> Login</a></span></p>
                        </div>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>
@endsection
