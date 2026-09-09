@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-emerald-300 bg-emerald-50 p-4 text-base font-medium text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300']) }} role="status" aria-live="polite">
        {{ $status }}
    </div>
@endif
