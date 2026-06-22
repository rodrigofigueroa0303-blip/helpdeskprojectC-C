@props(['type' => 'info'])
@php
$map = [
  'info'    => 'alert-info',
  'success' => 'alert-success',
  'warning' => 'alert-warning',
  'error'   => 'alert-error',
];
@endphp
<div {{ $attributes->merge(['class' => $map[$type]]) }}>
  {{ $slot }}
</div>
