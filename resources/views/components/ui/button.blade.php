@props([
  'type' => 'button',
  'variant' => 'primary',
  'size' => 'md',
  'href' => null,
  'as' => null,
])

@php
$base = 'inline-flex items-center justify-center font-medium transition-all duration-200 rounded-xl active:scale-[0.97]';

$sizes = [
  'sm' => 'px-3 py-1.5 text-sm',
  'md' => 'px-4 py-2 text-sm',
  'lg' => 'px-5 py-2.5 text-base',
][$size];

$variants = [
  'primary'   => 'bg-brand text-white hover:bg-brand-700 focus-visible:ring-2 focus-visible:ring-brand/40 shadow-sm',
  'secondary' => 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 hover:border-gray-300 focus-visible:ring-2 focus-visible:ring-gray-300/40 shadow-sm',
  'ghost'     => 'bg-transparent text-gray-600 hover:bg-gray-100 focus-visible:ring-2 focus-visible:ring-gray-300/40',
  'danger'    => 'bg-red-600 text-white hover:bg-red-500 focus-visible:ring-2 focus-visible:ring-red-400/40 shadow-sm',
][$variant];

$classes = "$base $sizes $variants";
@endphp

@if($href || $as === 'a')
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </a>
@else
  <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </button>
@endif
