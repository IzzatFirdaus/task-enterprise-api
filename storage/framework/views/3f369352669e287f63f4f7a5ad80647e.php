<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if (isset($component)) { $__componentOriginal4232ba5ed77147a6b6573253fafb715d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4232ba5ed77147a6b6573253fafb715d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seo-head','data' => ['title' => $title ?? 'Operational work, made clear','description' => $description ?? 'A focused task workspace for personal execution and accountable administration.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seo-head'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? 'Operational work, made clear'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description ?? 'A focused task workspace for personal execution and accountable administration.')]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4232ba5ed77147a6b6573253fafb715d)): ?>
<?php $attributes = $__attributesOriginal4232ba5ed77147a6b6573253fafb715d; ?>
<?php unset($__attributesOriginal4232ba5ed77147a6b6573253fafb715d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4232ba5ed77147a6b6573253fafb715d)): ?>
<?php $component = $__componentOriginal4232ba5ed77147a6b6573253fafb715d; ?>
<?php unset($__componentOriginal4232ba5ed77147a6b6573253fafb715d); ?>
<?php endif; ?>
        <?php
            $structuredData = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'SoftwareApplication',
                        'name' => config('app.name', 'Enterprise Tasks'),
                        'applicationCategory' => 'BusinessApplication',
                        'operatingSystem' => 'Web',
                        'description' => $description ?? 'A focused task workspace for personal execution and accountable administration.',
                        'url' => url('/'),
                        'provider' => ['@id' => url('/').'#organization'],
                    ],
                    [
                        '@type' => 'Organization',
                        '@id' => url('/').'#organization',
                        'name' => config('app.name', 'Enterprise Tasks'),
                        'url' => url('/'),
                        'email' => config('app.seo.contact_email'),
                    ],
                ],
            ];
        ?>
        <script type="application/ld+json"><?php echo json_encode($structuredData, JSON_UNESCAPED_SLASHES); ?></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="min-h-full bg-slate-950 font-sans text-slate-100 antialiased">
        <a href="#main-content" class="skip-link">Skip to content</a>
        <header class="border-b border-slate-800 bg-slate-950/95">
            <nav class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-5" aria-label="Public navigation">
                <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400" aria-label="Enterprise Tasks home">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-cyan-600 text-sm font-bold text-white">ET</span>
                    <span><strong class="block text-sm tracking-wide text-white">Enterprise Tasks</strong><span class="text-xs text-slate-400">Operational clarity</span></span>
                </a>
                <div class="hidden items-center gap-4 text-sm font-semibold text-slate-300 sm:flex">
                    <a href="<?php echo e(route('capabilities')); ?>" class="hidden hover:text-cyan-300 sm:inline">Capabilities</a>
                    <a href="<?php echo e(route('blog.index')); ?>" class="hidden hover:text-cyan-300 sm:inline">Journal</a>
                    <a href="<?php echo e(route('login')); ?>" class="rounded-lg border border-slate-700 px-3 py-2 hover:border-cyan-500 hover:text-white">Sign in</a>
                </div>
                <details class="relative sm:hidden">
                    <summary class="flex min-h-11 cursor-pointer list-none items-center rounded-lg border border-slate-700 px-3 py-2 text-sm font-semibold text-slate-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400" aria-label="Open navigation menu">
                        <span aria-hidden="true">Menu</span>
                    </summary>
                    <div class="absolute right-0 top-14 z-50 w-48 rounded-lg border border-slate-700 bg-slate-900 p-2 text-sm font-semibold text-slate-200 shadow-xl">
                        <a href="<?php echo e(route('capabilities')); ?>" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Capabilities</a>
                        <a href="<?php echo e(route('blog.index')); ?>" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Journal</a>
                        <a href="<?php echo e(route('login')); ?>" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Sign in</a>
                    </div>
                </details>
            </nav>
        </header>
        <main id="main-content"><?php echo $__env->yieldContent('content'); ?></main>
        <footer class="border-t border-slate-800 bg-slate-950">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-5 py-8 text-sm text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; <?php echo e(date('Y')); ?> Enterprise Tasks. Built for focused work.</p>
                <div class="flex flex-wrap gap-4"><a href="<?php echo e(route('about')); ?>" class="hover:text-white">About</a><a href="<?php echo e(route('terms')); ?>" class="hover:text-white">Terms</a><a href="mailto:<?php echo e(config('app.seo.contact_email')); ?>" class="hover:text-cyan-300"><?php echo e(config('app.seo.contact_email')); ?></a></div>
            </div>
        </footer>
        <?php if (isset($component)) { $__componentOriginalfb3ba51392cb9385dccbb71c02b518a6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfb3ba51392cb9385dccbb71c02b518a6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.site-enhancements','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-enhancements'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfb3ba51392cb9385dccbb71c02b518a6)): ?>
<?php $attributes = $__attributesOriginalfb3ba51392cb9385dccbb71c02b518a6; ?>
<?php unset($__attributesOriginalfb3ba51392cb9385dccbb71c02b518a6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfb3ba51392cb9385dccbb71c02b518a6)): ?>
<?php $component = $__componentOriginalfb3ba51392cb9385dccbb71c02b518a6; ?>
<?php unset($__componentOriginalfb3ba51392cb9385dccbb71c02b518a6); ?>
<?php endif; ?>
    </body>
</html><?php /**PATH D:\Projects\task-enterprise-api\resources\views\layouts\public.blade.php ENDPATH**/ ?>