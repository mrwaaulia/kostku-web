<button
    {{ $attributes->merge([
        'class' => '
            px-5
            py-3
            w-full
            rounded-md
            bg-primary
            text-white
            lg:text-md
            text-sm
            font-medium
            hover:bg-secondary
            hover:text-primary
            transition
        '
    ]) }}>
    {{ $slot }}
</button>