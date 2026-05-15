@props([
'label' => '',
'name' => '',
'type' => 'text',
'placeholder' => '',
'required',
])

<div class="space-y-2">

    {{-- Label --}}
    @if($label)
    <label
        for="{{ $name }}"
        class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>
    @endif

    {{-- Wrapper --}}
    <div class="relative">

        {{-- Input --}}
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            required

            {{ $attributes->merge([
                'class' => '
                    w-full
                    rounded-xl
                    border
                    border-gray-300
                    px-4
                    py-3
                    placeholder:text-neutral
                    focus:outline-none
                    focus:ring-2
                    focus:ring-primary
                '
            ]) }}>

        {{-- Toggle Password --}}
        @if($type === 'password')

        <button
            type="button"

            onclick="
                    const input = document.getElementById('{{ $name }}');

                    const eyeOpen = document.getElementById('eye-open-{{ $name }}');
                    const eyeClose = document.getElementById('eye-close-{{ $name }}');

                    if(input.type === 'password') {

                        input.type = 'text';

                        eyeOpen.classList.remove('hidden');
                        eyeClose.classList.add('hidden');

                    } else {

                        input.type = 'password';

                        eyeOpen.classList.add('hidden');
                        eyeClose.classList.remove('hidden');
                    }
                "

            class="
                    absolute
                    right-4
                    top-1/2
                    -translate-y-1/2
                ">

            {{-- Mata Terbuka --}}
            <img
                id="eye-open-{{ $name }}"
                src="{{ asset('../assets/icons/eye-open.png') }}"
                class="hidden w-4 h-4"
                alt="Show Password">

            {{-- Mata Tertutup --}}
            <img
                id="eye-close-{{ $name }}"
                src="{{ asset('../assets/icons/eye-close.png') }}"
                class="w-4 h-4"
                alt="Hide Password">

        </button>

        @endif

    </div>

</div>