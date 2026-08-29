@props([
    'type' => 'status',
    'value' => 'pending',
    'size' => 'md',
])

@php
    $type = strtolower($type);
    $value = strtolower(trim($value));

    $colorClasses = match ($type) {
        'role' => match ($value) {
            'super_admin' => 'bg-purple-50 text-purple-700 border-purple-200 ring-purple-600/20',
            'admin' => 'bg-indigo-50 text-indigo-700 border-indigo-200 ring-indigo-600/20',
            'moderator' => 'bg-sky-50 text-sky-700 border-sky-200 ring-sky-600/20',
            default => 'bg-slate-50 text-slate-700 border-slate-200 ring-slate-600/20',
        },
        'account_status' => match ($value) {
            'suspended', 'inactive' => 'bg-rose-50 text-rose-700 border-rose-200 ring-rose-600/20',
            default => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/20',
        },
        default => match ($value) {
            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-600/20',
            'in_progress' => 'bg-cyan-50 text-cyan-700 border-cyan-200 ring-cyan-600/20',
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-600/20',
            default => 'bg-slate-50 text-slate-700 border-slate-200 ring-slate-600/20',
        },
    };

    $sizeClasses = match ($size) {
        'sm' => 'px-2 py-0.5 text-xs',
        'lg' => 'px-3 py-1.5 text-sm font-medium',
        default => 'px-2.5 py-1 text-xs font-medium',
    };

    $label = match ($value) {
        'super_admin' => 'Super Admin',
        'in_progress' => 'In Progress',
        default => ucfirst(str_replace('_', ' ', $value)),
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border ring-1 ring-inset {$colorClasses} {$sizeClasses} transition-colors"]) }}>
    @if ($type === 'account_status')
        <span class="h-1.5 w-1.5 rounded-full {{ $value === 'suspended' ? 'bg-rose-500' : 'bg-emerald-500' }}" aria-hidden="true"></span>
    @elseif ($type === 'status')
        <span class="h-1.5 w-1.5 rounded-full {{ $value === 'completed' ? 'bg-emerald-500' : ($value === 'in_progress' ? 'bg-cyan-500' : 'bg-amber-500') }}" aria-hidden="true"></span>
    @endif
    <span>{{ $slot->isEmpty() ? $label : $slot }}</span>
</span>
