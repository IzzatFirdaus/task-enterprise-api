@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-semibold uppercase tracking-wider text-slate-700']) }}>
    {{ $value ?? $slot }}
</label>
