@extends('layouts.app')
@section('title', 'Welcome')
@section('content')
<div class="p-14 w-full min-h-screen bg-cover bg-center bg-no-repeat " style="background-image: url('assets/images/bg-auth.png');">
    <img src="{{ asset('assets/images/logo-auth.png') }}" alt="logo" class="mb-4" width="150px">
    <div class="w-full h-auto flex flex-col justify-center items-center">
        <h1 class="text-primary md:text-4xl text-xl font-bold mb-4">Selamat Datang di Kostku</h1>
        <p class="text-black md:text-lg text-sm text-center mb-12">Pilih peranmu untuk mulai menggunakan aplikasi</p>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-20 mb-8 lg:mb-14">
            <a href="{{ route('register.penghuni') }}" class="bg-white flex flex-col justify-center items-center max-w-sm p-6 border border-default rounded-md shadow-xs hover:bg-neutral-secondary-medium">
                <img src="{{ asset('assets/icons/penghuni-icon.png') }}" alt="penghuni" class="mb-2">
                <h5 class="mb-3 md:text-lg text-md font-semibold tracking-tight text-heading leading-8">Penghuni</h5>
                <p class="text-body md:text-sm text-[12px] text-center">Kelola aktivitas sebagai penghuni kost</p>
            </a>
            <a href="{{ route('register.pengelola') }}" class="bg-white flex flex-col justify-center items-center max-w-sm p-6 border border-default rounded-md shadow-xs hover:bg-neutral-secondary-medium">
                <img src="{{ asset('assets/icons/pengelola-icon.png') }}" alt="pengelola" class="mb-2">
                <h5 class="mb-3 md:text-lg text-md font-semibold tracking-tight text-heading leading-8">Pengelola</h5>
                <p class="text-body md:text-sm text-[12px] text-center">Kelola kost dengan praktis</p>
            </a>
        </div>
        <p class="md:text-md text-sm text-[#686868]">Sudah punya akun?<span class="text-primary font-semibold"><a href="{{ route('login') }}"> Login</a></span></p>

    </div>
</div>

@endsection