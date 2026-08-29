<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950 dark:text-white">Task Moderation</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Audit system-wide workload, review ownership, and manage task lifecycle states.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-50 dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                Total Moderated Tasks: <span class="font-bold text-slate-900 dark:text-white"><?php echo e($tasks->total()); ?></span>
            </div>
        </div>

        <!-- Moderation Table Card -->
        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-700 text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            <th scope="col" class="pb-3 pr-4">Owner</th>
                            <th scope="col" class="pb-3 px-4">Task Deliverable</th>
                            <th scope="col" class="pb-3 px-4">Lifecycle Status</th>
                            <th scope="col" class="pb-3 px-4">Created Date</th>
                            <th scope="col" class="pb-3 pl-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="group transition hover:bg-slate-50/80 dark:hover:bg-slate-700/50">
                                <!-- Owner -->
                                <td class="py-3.5 pr-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-[11px] font-bold text-slate-700 dark:text-slate-200">
                                            <?php echo e(strtoupper(substr($task->user?->name ?? 'U', 0, 2))); ?>

                                        </div>
                                        <div>
                                            <div class="font-medium text-xs text-slate-900 dark:text-slate-100"><?php echo e($task->user?->name ?? 'Unassigned'); ?></div>
                                            <div class="text-[10px] text-slate-400 dark:text-slate-500"><?php echo e($task->user?->email); ?></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Task Title & Description -->
                                <td class="py-3.5 px-4 align-middle">
                                    <div class="font-medium text-slate-900 dark:text-slate-100"><?php echo e($task->title); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($task->description): ?>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 line-clamp-1 mt-0.5"><?php echo e($task->description); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
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
                                </td>

                                <!-- Created -->
                                <td class="py-3.5 px-4 align-middle whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                    <?php echo e($task->created_at?->format('M d, Y') ?? 'N/A'); ?>

                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 pl-4 align-middle text-right whitespace-nowrap">
                                    <form method="POST" action="<?php echo e(route('admin.tasks.delete', $task)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1 rounded-lg border border-rose-200 dark:border-rose-900/60 bg-rose-50 dark:bg-rose-950/50 px-2.5 py-1.5 text-xs font-medium text-rose-700 dark:text-rose-300 shadow-2xs hover:bg-rose-100 dark:hover:bg-rose-900/60 hover:border-rose-300"
                                            aria-label="Delete task <?php echo e($task->title); ?>"
                                        >
                                            <svg class="h-3.5 w-3.5 text-rose-600 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="5" class="py-12 text-center text-xs text-slate-500 dark:text-slate-400">
                                    No tasks available for moderation.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tasks->hasPages()): ?>
                <div class="mt-6 border-t border-slate-100 dark:border-slate-700 pt-4">
                    <?php echo e($tasks->links()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\task-enterprise-api\resources\views/admin/tasks/index.blade.php ENDPATH**/ ?>