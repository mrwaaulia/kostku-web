@props([
'type' => 'default', // success, warning, danger, info
])

@php
$classes = match($type) {
'success' => 'bg-[#CFEFC7] text-[#479135]',
'warning' => 'bg-[#FEF5B2] text-[#B39E04]',
'danger' => 'bg-[#FFC5BF] text-[#B43024]',
'info' => 'bg-blue-100 text-blue-700',
default => 'bg-gray-100 text-gray-700',
};
@endphp

<span {{ $attributes->merge([
    'class' => "px-4 py-2 text-xs rounded-md font-medium $classes"
]) }}>
    {{ $slot }}
</span>