@props(['label' => null, 'name' => null, 'type' => 'text'])

@if($label)
  <label for="{{ $name }}" class="text-sm font-medium text-gray-700">{{ $label }}</label>
@endif
<input
  id="{{ $name }}"
  name="{{ $name }}"
  type="{{ $type }}"
  {{ $attributes->merge(['class' => 'input mt-1']) }}
/>
@error($name)
  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
