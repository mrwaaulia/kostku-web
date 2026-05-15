@props([
'type' => 'default', // success, warning, danger, info
])

@php
$classes = match($type) {
'success' => 'bg-[#CFEFC7] text-[#479135]',
'warning' => 'bg-[#FEF5B2] text-[#B39E04]',
'danger' => 'bg-[#FFC5BF] text-[#B43024]',
'info' => 'bg-secondary text-primary',
default => 'bg-gray-100 text-neutral border border-2 border-[#E2E2E2]',
};
@endphp

<span {{ $attributes->merge([
    'class' => "px-4 py-2 text-xs rounded-md font-medium $classes"
]) }}>
    {{ $slot }}
</span>