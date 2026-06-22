@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-white/15 transition duration-150 ease-in-out'
            : 'block w-full px-4 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
