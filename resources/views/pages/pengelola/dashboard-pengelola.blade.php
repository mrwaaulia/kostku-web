@extends('layouts.pengelola')
@section('title', 'Dashboard Pengelola')

@section('content')

<div class="space-y-6">

    {{-- ================= PAGE HEADER ================= --}}
    <x-page-header
        title="Dashboard"
        description="Pantau data kost dan aktivitas penghuni">

    </x-page-header>


    {{-- ================= CARD STATISTIK ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Total Penghuni --}}
        <div class="bg-white border border-yellow-400 rounded-2xl p-4 lg:p-5">

            <img
                src="{{ asset('assets/icons/pengelola-dashboard-jumlahpenghuni-icon.png') }}"
                alt="Total Penghuni"
                class="w-9 h-9 lg:w-10 lg:h-10 mb-4">

            <p class="text-xs lg:text-sm text-neutral mb-1">
                Total Penghuni
            </p>

            <h2 class="text-2xl lg:text-3xl font-bold text-yellow-500">
                3
            </h2>

        </div>


        {{-- Kamar Terisi --}}
        <div class="bg-white border border-green-400 rounded-2xl p-4 lg:p-5">

            <img
                src="{{ asset('assets/icons/pengelola-dashboard-kamarterisi-icon.png') }}"
                alt="Kamar Terisi"
                class="w-9 h-9 lg:w-10 lg:h-10 mb-4">

            <p class="text-xs lg:text-sm text-neutral mb-1">
                Kamar Terisi
            </p>

            <h2 class="text-2xl lg:text-3xl font-bold text-green-500">
                3
            </h2>

        </div>


        
        {{-- Kamar Kosong --}}
        <div class="bg-white border border-red-400 rounded-2xl p-4 lg:p-5">

            <img
                src="{{ asset('assets/icons/pengelola-dashboard-kamarkosong-icon.png') }}"
                alt="Kamar Kosong"
                class="w-9 h-9 lg:w-10 lg:h-10 mb-4">

            <p class="text-xs lg:text-sm text-neutral mb-1">
                Kamar Kosong
            </p>

            <h2 class="text-2xl lg:text-3xl font-bold text-red-500">
                3
            </h2>

        </div>


        {{-- Pendapatan --}}
        <div class="bg-white border border-primary rounded-2xl p-4 lg:p-5">

            <img
                src="{{ asset('assets/icons/pengelola-dashboard-pendapatan-icon.png') }}"
                alt="Pendapatan"
                class="w-9 h-9 lg:w-10 lg:h-10 mb-4">

            <p class="text-xs lg:text-sm text-neutral mb-1">
                Pendapatan Bulan Ini
            </p>

            <h2 class="text-xl lg:text-2xl font-bold text-primary break-words">
                Rp1.000.000
            </h2>

        </div>

    </div>


    {{-- ================= TABLE SECTION ================= --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Pembayaran --}}
        <div class="bg-white rounded-2xl p-4 lg:p-6">

            <div class="flex items-center justify-between mb-5">

                <h2 class="text-base lg:text-lg font-bold">
                    Pembayaran Terbaru
                </h2>

                <a
                    href="{{ route('pembayaran.pengelola') }}"
                    class="text-primary text-xs lg:text-sm hover:underline">

                    Lihat Semua

                </a>

            </div>

            <div class="space-y-4">

                <div class="flex items-center justify-between border-b pb-3 gap-3">

                    <p class="text-xs lg:text-sm">
                        P001 - Anto Subagja
                    </p>

                    <p class="text-xs lg:text-sm font-medium">
                        Rp500.000
                    </p>

                </div>

                <div class="flex items-center justify-between border-b pb-3 gap-3">

                    <p class="text-xs lg:text-sm">
                        P002 - Tono Sukamto
                    </p>

                    <p class="text-xs lg:text-sm font-medium">
                        Rp500.000
                    </p>

                </div>

                <div class="flex items-center justify-between gap-3">

                    <p class="text-xs lg:text-sm">
                        P003 - Saifullah Fattah
                    </p>

                    <p class="text-xs lg:text-sm font-medium">
                        Rp500.000
                    </p>

                </div>

            </div>

        </div>


        {{-- Pengaduan --}}
        <div class="bg-white rounded-2xl p-4 lg:p-6">

            <div class="flex items-center justify-between mb-5">

                <h2 class="text-base lg:text-lg font-bold">
                    Pengaduan Terbaru
                </h2>

                <a
                    href="{{ route('pengaduan.pengelola') }}"
                    class="text-primary text-xs lg:text-sm hover:underline">

                    Lihat Semua

                </a>

            </div>

            <div class="space-y-4">

                <div class="flex items-center justify-between border-b pb-3 gap-3">

                    <p class="text-xs lg:text-sm">
                        P001 - Anto Subagja
                    </p>

                    <span class="px-3 py-1 rounded-lg text-[10px] lg:text-xs bg-red-200 text-red-700">
                        Baru
                    </span>

                </div>

                <div class="flex items-center justify-between border-b pb-3 gap-3">

                    <p class="text-xs lg:text-sm">
                        P002 - Tono Sukamto
                    </p>

                    <span class="px-3 py-1 rounded-lg text-[10px] lg:text-xs bg-yellow-200 text-yellow-700">
                        Proses
                    </span>

                </div>

                <div class="flex items-center justify-between gap-3">

                    <p class="text-xs lg:text-sm">
                        P003 - Saifullah Fattah
                    </p>

                    <span class="px-3 py-1 rounded-lg text-[10px] lg:text-xs bg-green-200 text-green-700">
                        Selesai
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection