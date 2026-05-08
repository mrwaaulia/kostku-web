@extends('layouts.pengelola')
@section('title', 'Penghuni')

@section('content')

<div class="space-y-6">

    {{-- ================= PAGE HEADER ================= --}}
    <x-page-header
        title="Data Penghuni"
        description="Daftar penghuni dan kelola permintaan">

    </x-page-header>


    {{-- ================= SEARCH ================= --}}
    <div class="bg-white rounded-lg p-3">

        <div class="relative">

            {{-- SEARCH ICON --}}
            <svg
                class="
                    absolute left-3 top-1/2 -translate-y-1/2
                    w-4 h-4 text-gray-400
                "
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m21 21-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" />

            </svg>

            <input
                type="text"
                placeholder="Cari"
                class="
                    w-full pl-10 pr-4 py-2.5
                    rounded-lg border border-gray-200
                    text-xs lg:text-sm

                    focus:outline-none
                    focus:ring-2
                    focus:ring-primary
                    focus:border-primary
                ">

        </div>

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-lg p-4 lg:p-6">

        {{-- ================= TAB ================= --}}
        <div class="flex gap-6 mb-6 min-w-max border-b">

            <button
                class="
                    pb-3 border-b-2 border-primary
                    text-primary font-medium
                    text-xs lg:text-sm
                ">

                Daftar Penghuni

            </button>

            <button
                class="
                    pb-3 border-b-2 border-transparent
                    text-neutral
                    text-xs lg:text-sm
                ">

                Permintaan Masuk

            </button>

            <button
                class="
                    pb-3 border-b-2 border-transparent
                    text-neutral
                    text-xs lg:text-sm
                ">

                Permintaan Keluar

            </button>

        </div>


        {{-- ================= TABLE CONTENT ================= --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px] table-fixed">

                <thead>

                    <tr class="border-b">

                        <th class="w-[28%] text-left py-4 px-2 text-xs lg:text-sm font-semibold">
                            Nama Lengkap
                        </th>

                        <th class="w-[22%] text-left py-4 px-2 text-xs lg:text-sm font-semibold">
                            No HP
                        </th>

                        <th class="w-[15%] text-left py-4 px-2 text-xs lg:text-sm font-semibold">
                            Kamar
                        </th>

                        <th class="w-[20%] text-left py-4 px-2 text-xs lg:text-sm font-semibold">
                            Tanggal Masuk
                        </th>

                        <th class="w-[15%] text-center py-4 px-2 text-xs lg:text-sm font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr class="border-b">

                        <td class="py-4 px-2 text-xs lg:text-sm">
                            Anto Subagja
                        </td>

                        <td class="py-4 px-2 text-xs lg:text-sm">
                            081234567892
                        </td>

                        <td class="py-4 px-2 text-xs lg:text-sm">
                            KM001
                        </td>

                        <td class="py-4 px-2 text-xs lg:text-sm">
                            08/04/2026
                        </td>

                        <td class="py-4 px-2">

                            <div class="flex justify-center">

                                <a
                                    href="#"
                                    class="
                                        p-2 rounded-md
                                        hover:bg-blue-50
                                        transition
                                    ">

                                    <img
                                        src="{{ asset('assets/icons/lihat-detail-icon.png') }}"
                                        alt="Lihat Detail"
                                        class="w-4 h-4">

                                </a>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- ================= PAGINATION ================= --}}
    <x-pagination />

</div>

@endsection