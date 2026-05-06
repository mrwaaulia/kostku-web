@props([
'show' => false,
'maxWidth' => 'md',
])

@php
$maxWidthClass = match($maxWidth) {
'sm' => 'max-w-sm',
'md' => 'max-w-md',
'lg' => 'max-w-lg',
'xl' => 'max-w-xl',
default => $maxWidth,
};
@endphp

<div
    x-show="{{ $show }}"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none;">
    <x-card class="w-full {{ $maxWidthClass }}">

        {{-- HEADER --}}
        @isset($header)
        <div class="mb-4">
            {{ $header }}
        </div>
        @endisset

        {{-- BODY --}}
        <div class="mb-4">
            {{ $slot }}
        </div>

        {{-- FOOTER --}}
        @isset($footer)
        <div class="mt-4">
            {{ $footer }}
        </div>
        @endisset

    </x-card>
</div>