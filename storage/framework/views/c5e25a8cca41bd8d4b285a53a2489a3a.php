<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950 dark:text-white">Administrative Audit Trails</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Immutable record of security events, privilege updates, and account actions.</p>
            </div>
            <a
                href="<?php echo e(route('admin.audit-logs.export')); ?>"
                class="inline-flex items-center gap-2 rounded-xl bg-slate-900 dark:bg-slate-700 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-cyan-700 dark:hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-slate-900"
            >
                <svg class="h-4 w-4 text-cyan-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Export CSV
            </a>
        </div>

        <!-- Audit Table Card -->
        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-700 text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            <th scope="col" class="pb-3 pr-4">Administrator</th>
                            <th scope="col" class="pb-3 px-4">Event Action</th>
                            <th scope="col" class="pb-3 px-4">Target Entity</th>
                            <th scope="col" class="pb-3 px-4">Origin IP</th>
                            <th scope="col" class="pb-3 px-4">Payload / Changes</th>
                            <th scope="col" class="pb-3 pl-4 text-right">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="group transition hover:bg-slate-50/80 dark:hover:bg-slate-700/50">
                                <!-- Admin User -->
                                <td class="py-3.5 pr-4 align-top whitespace-nowrap">
                                    <div class="font-medium text-xs text-slate-900 dark:text-slate-100"><?php echo e($log->admin?->name ?? 'Automated System'); ?></div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500"><?php echo e($log->admin?->email ?? 'system@internal'); ?></div>
                                </td>

                                <!-- Action Badge -->
                                <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 px-2.5 py-0.5 text-xs font-semibold text-slate-700 dark:text-slate-300">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $log->action))); ?>

                                    </span>
                                </td>

                                <!-- Model Type & ID -->
                                <td class="py-3.5 px-4 align-top whitespace-nowrap text-xs text-slate-700 dark:text-slate-300">
                                    <span class="font-medium"><?php echo e($log->model_type ?? 'Entity'); ?></span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->model_id): ?>
                                        <span class="text-slate-400 dark:text-slate-500">#<?php echo e($log->model_id); ?></span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                <!-- IP Address -->
                                <td class="py-3.5 px-4 align-top whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                    <span class="rounded-md bg-slate-100 dark:bg-slate-700 px-2 py-0.5 font-mono text-[11px] text-slate-600 dark:text-slate-300">
                                        <?php echo e($log->ip_address ?? '127.0.0.1'); ?>

                                    </span>
                                </td>

                                <!-- Changes Preview -->
                                <td class="py-3.5 px-4 align-top text-xs text-slate-600 dark:text-slate-300">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($log->changes)): ?>
                                        <details class="group/details cursor-pointer">
                                            <summary class="text-xs font-semibold text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 focus:outline-none">
                                                View parameters
                                            </summary>
                                            <pre class="mt-1.5 max-w-xs overflow-x-auto rounded-lg bg-slate-950 p-2.5 text-[11px] font-mono text-emerald-400 shadow-inner sm:max-w-sm"><?php echo e(json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>
                                        </details>
                                    <?php else: ?>
                                        <span class="text-slate-400 dark:text-slate-500">—</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                <!-- Timestamp -->
                                <td class="py-3.5 pl-4 align-top text-right whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                    <?php echo e($log->created_at?->format('M d, Y H:i:s') ?? 'N/A'); ?>

                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="6" class="py-12 text-center text-xs text-slate-500 dark:text-slate-400">
                                    No audit entries match the current history.
                                </td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logs->hasPages()): ?>
                <div class="mt-6 border-t border-slate-100 dark:border-slate-700 pt-4">
                    <?php echo e($logs->links()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\task-enterprise-api\resources\views\admin\audit-logs.blade.php ENDPATH**/ ?>