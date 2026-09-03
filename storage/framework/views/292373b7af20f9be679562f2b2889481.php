<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center sm:p-8">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full bg-cyan-50 dark:bg-cyan-950/60 px-3 py-1 text-xs font-semibold text-cyan-800 dark:text-cyan-400 ring-1 ring-inset ring-cyan-700/10 dark:ring-cyan-500/20">
                <span class="h-1.5 w-1.5 rounded-full bg-cyan-600 dark:bg-cyan-400"></span>
                Operations Workspace
            </div>
            <h1 class="mt-2 text-2xl sm:text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Task Command Center</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 max-w-xl">Keep delivery moving with real-time tracking of active deliverables.</p>
        </div>
        <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400">
            <span><?php echo e(now()->format('D, M j, Y')); ?></span>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 shadow-sm" role="status">
            <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [['label' => 'Total tasks', 'value' => $counts['all'], 'color' => 'text-slate-950 dark:text-white'], ['label' => 'Pending', 'value' => $counts['pending'], 'color' => 'text-amber-700 dark:text-amber-400'], ['label' => 'In progress', 'value' => $counts['in_progress'], 'color' => 'text-cyan-700 dark:text-cyan-400'], ['label' => 'Completed', 'value' => $counts['completed'], 'color' => 'text-emerald-700 dark:text-emerald-400']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400"><?php echo e($stat['label']); ?></p>
                <p class="mt-2 text-3xl font-bold tracking-tight <?php echo e($stat['color']); ?>"><?php echo e($stat['value']); ?></p>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
        <section class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="mb-4 border-b border-slate-100 dark:border-slate-700 pb-3">
                <h2 class="text-base font-semibold text-slate-950 dark:text-white">Create a task</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Add a piece of work to your queue.</p>
            </div>
            <form wire:submit="addTask" class="space-y-4">
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Title <span class="text-rose-500">*</span></label>
                    <input id="title" type="text" wire:model.blur="title" maxlength="255" required class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20" placeholder="e.g. Review release plan">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Description <span class="font-normal text-slate-400 dark:text-slate-500">(optional)</span></label>
                    <textarea id="description" wire:model.blur="description" rows="3" maxlength="5000" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20" placeholder="Add context, acceptance criteria, or links."></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Starting status</label>
                    <select id="status" wire:model="status" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-700 dark:bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-800 dark:hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 disabled:opacity-60">Add task</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <div>
                    <h2 class="text-base font-semibold text-slate-950 dark:text-white">Your tasks</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Latest activity first</p>
                </div>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400"><?php echo e($counts['all']); ?> total</span>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <article <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'task-'.e($task->id).''; ?>wire:key="task-<?php echo e($task->id); ?>" class="flex flex-col gap-4 py-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-medium text-sm <?php echo e($task->status === 'completed' ? 'text-slate-400 dark:text-slate-500 line-through' : 'text-slate-900 dark:text-slate-100'); ?>"><?php echo e($task->title); ?></h3>
                                <?php if (isset($component)) { $__componentOriginal2ddbc40e602c342e508ac696e52f8719 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2ddbc40e602c342e508ac696e52f8719 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.badge','data' => ['type' => 'status','value' => $task->status,'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'status','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($task->status),'size' => 'sm']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $attributes = $__attributesOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__attributesOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2ddbc40e602c342e508ac696e52f8719)): ?>
<?php $component = $__componentOriginal2ddbc40e602c342e508ac696e52f8719; ?>
<?php unset($__componentOriginal2ddbc40e602c342e508ac696e52f8719); ?>
<?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($task->description): ?><p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400"><?php echo e($task->description); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <p class="mt-2 text-[11px] text-slate-400 dark:text-slate-500">Created <?php echo e($task->created_at?->diffForHumans() ?? 'recently'); ?></p>
                        </div>
                        <div class="flex shrink-0 gap-1.5">
                            <button type="button" wire:click="toggleStatus(<?php echo e($task->id); ?>)" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-2.5 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-200 shadow-2xs hover:bg-slate-50 dark:hover:bg-slate-600">Advance</button>
                            <button type="button" wire:click="deleteTask(<?php echo e($task->id); ?>)" wire:confirm="Delete this task?" class="rounded-lg border border-rose-200 dark:border-rose-900/60 bg-white dark:bg-slate-700 px-2.5 py-1.5 text-xs font-medium text-rose-600 dark:text-rose-400 shadow-2xs hover:bg-rose-50 dark:hover:bg-rose-950/50">Delete</button>
                        </div>
                    </article>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="py-12 text-center">
                        <p class="font-medium text-sm text-slate-900 dark:text-slate-100">No tasks yet</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Create your first task to start tracking delivery.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </section>
    </div>
</div>
<?php /**PATH D:\Projects\task-enterprise-api\resources\views\livewire\task-manager.blade.php ENDPATH**/ ?>