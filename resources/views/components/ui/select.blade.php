@props(['label' => null, 'name' => null, 'options' => []])

@if($label)
  <label for="{{ $name }}" class="text-sm font-medium text-gray-700">{{ $label }}</label>
@endif
<select
  id="{{ $name }}"
  name="{{ $name }}"
  {{ $attributes->merge(['class' => 'select mt-1']) }}
>
  {{ $slot }}
</select>
@error($name)
  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
