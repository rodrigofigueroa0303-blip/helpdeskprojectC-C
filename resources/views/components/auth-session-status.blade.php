@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-emerald-600 bg-emerald-50 rounded-xl px-4 py-3 border border-emerald-200']) }}>
        {{ $status }}
    </div>
@endif
