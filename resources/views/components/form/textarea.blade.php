@props([
'label' => '',
'name',
'placeholder' => '',
'rows' => 4,
])

<div class="space-y-2">

    @if($label)
    <label
        for="{{ $name }}"
        class="block text-sm font-medium text-gray-700">
        {{ $label }}
    </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"

        {{ $attributes->merge([
            'class' => '
                w-full
                rounded-xl
                placeholder:text-neutral
                border
                border-gray-300
                px-4
                py-3
                focus:outline-none
                focus:ring-2
                focus:ring-primary
                focus:border-primary
            '
        ]) }}>{{ old($name) }}</textarea>

    @error($name)
    <p class="text-sm text-red-500">
        {{ $message }}
    </p>
    @enderror

</div>