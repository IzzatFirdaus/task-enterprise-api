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
            'super_admin', 'admin', 'moderator' => 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border-slate-300 dark:border-slate-600',
            default => 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-300 dark:border-slate-600',
        },
        'account_status' => match ($value) {
            'suspended', 'inactive' => 'bg-rose-50 dark:bg-rose-950/60 text-rose-800 dark:text-rose-200 border-rose-300 dark:border-rose-700',
            default => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-200 border-emerald-300 dark:border-emerald-700',
        },
        default => match ($value) {
            'completed' => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-200 border-emerald-300 dark:border-emerald-700',
            'in_progress' => 'bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-200 border-teal-300 dark:border-teal-700',
            'pending' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-amber-200 border-amber-300 dark:border-amber-700',
            default => 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-300 dark:border-slate-600',
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

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-md border {$colorClasses} {$sizeClasses} transition-colors duration-150"]) }}>
    @if ($type === 'account_status')
        <span class="h-1.5 w-1.5 rounded-full {{ $value === 'suspended' ? 'bg-rose-500' : 'bg-emerald-500' }}" aria-hidden="true"></span>
    @elseif ($type === 'status')
        <span class="h-1.5 w-1.5 rounded-full {{ $value === 'completed' ? 'bg-emerald-500' : ($value === 'in_progress' ? 'bg-cyan-500' : 'bg-amber-500') }}" aria-hidden="true"></span>
    @endif
    <span>{{ $slot->isEmpty() ? $label : $slot }}</span>
</span>
