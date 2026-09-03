<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'loading' => null,
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
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'loading' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $variantClasses = match ($variant) {
        'secondary' => 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white focus:ring-slate-400 active:bg-slate-100 dark:active:bg-slate-700 shadow-sm',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 dark:hover:bg-rose-500 focus:ring-rose-500 active:bg-rose-800 shadow-sm',
        'outline' => 'bg-transparent text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white focus:ring-slate-400',
        'ghost' => 'bg-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white focus:ring-slate-400',
        'admin' => 'bg-slate-900 dark:bg-slate-700 text-white hover:bg-cyan-700 dark:hover:bg-cyan-600 focus:ring-cyan-500 active:bg-slate-950 dark:active:bg-slate-800 shadow-sm',
        default => 'bg-cyan-700 dark:bg-cyan-600 text-white hover:bg-cyan-800 dark:hover:bg-cyan-500 focus:ring-cyan-500 active:bg-cyan-900 dark:active:bg-cyan-700 shadow-sm',
    };

    $sizeClasses = match ($size) {
        'xs' => 'px-2.5 py-1 text-xs font-medium rounded-md gap-1 min-h-[32px]',
        'sm' => 'px-3 py-1.5 text-xs sm:text-sm font-medium rounded-lg gap-1.5 min-h-[36px]',
        'lg' => 'px-5 py-3 text-base font-semibold rounded-xl gap-2 min-h-[48px]',
        default => 'px-4 py-2.5 text-sm font-medium rounded-lg gap-2 min-h-[40px]',
    };
?>

<button
    type="<?php echo e($type); ?>"
    <?php echo e($attributes->merge([
        'class' => "inline-flex items-center justify-center font-medium transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-900 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer select-none {$variantClasses} {$sizeClasses}",
    ])); ?>

    <?php if($loading): ?>
        wire:loading.attr="disabled"
    <?php endif; ?>
>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loading): ?>
        <svg wire:loading wire:target="<?php echo e($loading); ?>" class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php echo e($slot); ?>

</button>
<?php /**PATH D:\Projects\task-enterprise-api\resources\views\components\button.blade.php ENDPATH**/ ?>