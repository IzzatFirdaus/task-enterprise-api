@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300']) }}>
    {{ $value ?? $slot }}
</label>
