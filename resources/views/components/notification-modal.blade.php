<x-modal show="notifOpen" maxWidth="max-w-xl" class="bg-[#F8F8F8]">

    {{-- HEADER --}}
    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-lg font-bold">
                    Notifikasi
                </h2>
            </div>

            {{-- CLOSE --}}
            <button
                type="button"
                class="text-xl text-neutral hover:text-black"
                @click="notifOpen = false">

                ✕

            </button>

        </div>

    </x-slot>


    {{-- BODY --}}
    <div class="space-y-3 max-h-[400px] overflow-y-auto pr-1">

        {{-- ITEM --}}
        <div class="border rounded-md p-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#FEF5B2] flex items-center justify-center shrink-0">
                    <img
                        src="{{ asset('assets/icons/Information-warning.png') }}"
                        class="w-5 h-5">
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold">
                        Pembayaran akan jatuh tempo 3 hari lagi
                    </h3>
                    <p class="text-xs text-neutral my-1">
                        Pembayaran untuk periode April 2026 akan jatuh tempo 3 hari lagi (11 April 2026)
                    </p>
                    <p class="text-[11px] text-neutral">
                        2 jam lalu
                    </p>
                </div>
            </div>
        </div>
        <div class="border rounded-md p-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#FFC5BF] flex items-center justify-center shrink-0">
                    <img
                        src="{{ asset('assets/icons/Information-danger.png') }}"
                        class="w-5 h-5">
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold">
                        Pembayaran jatuh tempo hari ini
                    </h3>
                    <p class="text-xs text-neutral my-1">
                        Jangan lupa untuk melakukan pembayaran periode Mei 2026
                    </p>
                    <p class="text-[11px] text-neutral">
                        1 hari yang lalu
                    </p>
                </div>
            </div>
        </div>

    </div>

</x-modal>