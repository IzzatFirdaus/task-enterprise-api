<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => config('app.name', 'Enterprise Tasks'),
    'description' => 'Enterprise Tasks keeps personal operational work organized, visible, and moving.',
    'robots' => 'index,follow',
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
    'title' => config('app.name', 'Enterprise Tasks'),
    'description' => 'Enterprise Tasks keeps personal operational work organized, visible, and moving.',
    'robots' => 'index,follow',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<meta name="description" content="<?php echo e($description); ?>">
<meta name="robots" content="<?php echo e($robots); ?>">
<link rel="canonical" href="<?php echo e(request()->url()); ?>">
<link rel="icon" href="<?php echo e(asset('favicon.svg')); ?>" type="image/svg+xml">
<link rel="icon" href="<?php echo e(asset('favicon-32x32.svg')); ?>" type="image/svg+xml" sizes="32x32">
<link rel="icon" href="<?php echo e(asset('favicon-192x192.svg')); ?>" type="image/svg+xml" sizes="192x192">
<link rel="apple-touch-icon" href="<?php echo e(asset('apple-touch-icon.svg')); ?>" sizes="180x180">
<link rel="manifest" href="<?php echo e(asset('site.webmanifest')); ?>">
<meta name="theme-color" content="#0e7490">
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('app.seo.google_verification')): ?>
    <meta name="google-site-verification" content="<?php echo e(config('app.seo.google_verification')); ?>">
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<title><?php echo e($title); ?> | <?php echo e(config('app.name', 'Enterprise Tasks')); ?></title><?php /**PATH D:\Projects\task-enterprise-api\resources\views\components\seo-head.blade.php ENDPATH**/ ?>