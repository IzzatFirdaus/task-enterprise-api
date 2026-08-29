<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'status',
    'value' => 'pending',
    'size' => 'md',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'type' => 'status',
    'value' => 'pending',
    'size' => 'md',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $type = strtolower($type);
    $value = strtolower(trim($value));

    $colorClasses = match ($type) {
        'role' => match ($value) {
            'super_admin' => 'bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border-purple-200 dark:border-purple-800 ring-purple-600/20 dark:ring-purple-400/20',
            'admin' => 'bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-800 ring-indigo-600/20 dark:ring-indigo-400/20',
            'moderator' => 'bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 border-sky-200 dark:border-sky-800 ring-sky-600/20 dark:ring-sky-400/20',
            default => 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 ring-slate-600/20 dark:ring-slate-400/20',
        },
        'account_status' => match ($value) {
            'suspended', 'inactive' => 'bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-800 ring-rose-600/20 dark:ring-rose-400/20',
            default => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800 ring-emerald-600/20 dark:ring-emerald-400/20',
        },
        default => match ($value) {
            'completed' => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800 ring-emerald-600/20 dark:ring-emerald-400/20',
            'in_progress' => 'bg-cyan-50 dark:bg-cyan-950/60 text-cyan-700 dark:text-cyan-300 border-cyan-200 dark:border-cyan-800 ring-cyan-600/20 dark:ring-cyan-400/20',
            'pending' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800 ring-amber-600/20 dark:ring-amber-400/20',
            default => 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700 ring-slate-600/20 dark:ring-slate-400/20',
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
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border ring-1 ring-inset {$colorClasses} {$sizeClasses} transition-colors"])); ?>>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'account_status'): ?>
        <span class="h-1.5 w-1.5 rounded-full <?php echo e($value === 'suspended' ? 'bg-rose-500' : 'bg-emerald-500'); ?>" aria-hidden="true"></span>
    <?php elseif($type === 'status'): ?>
        <span class="h-1.5 w-1.5 rounded-full <?php echo e($value === 'completed' ? 'bg-emerald-500' : ($value === 'in_progress' ? 'bg-cyan-500' : 'bg-amber-500')); ?>" aria-hidden="true"></span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <span><?php echo e($slot->isEmpty() ? $label : $slot); ?></span>
</span>
<?php /**PATH D:\Projects\task-enterprise-api\resources\views/components/badge.blade.php ENDPATH**/ ?>