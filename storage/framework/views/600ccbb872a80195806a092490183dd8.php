<section class="overflow-hidden border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-6 py-5">
        <h2 class="text-xl font-semibold text-slate-950">Your tasks</h2>
        <p class="mt-1 text-sm text-slate-500">Latest activity first</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-3 font-semibold">Task</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Created</th>
                    <th class="px-6 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'task-'.e($task->id).''; ?>wire:key="task-<?php echo e($task->id); ?>" class="hover:bg-slate-50">
                        <td class="max-w-sm px-6 py-4">
                            <p class="font-medium <?php echo e($task->status === 'completed' ? 'text-slate-400 line-through' : 'text-slate-950'); ?>"><?php echo e($task->title); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($task->description): ?><p class="mt-1 truncate text-slate-500"><?php echo e($task->description); ?></p><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4"><span class="px-2 py-1 text-xs font-medium <?php echo e($task->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : ($task->status === 'in_progress' ? 'bg-cyan-50 text-cyan-700' : 'bg-amber-50 text-amber-700')); ?>"><?php echo e(str_replace('_', ' ', ucfirst($task->status))); ?></span></td>
                        <td class="whitespace-nowrap px-6 py-4 text-slate-500"><?php echo e($task->created_at->format('M j, Y')); ?></td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <button type="button" wire:click="editTask(<?php echo e($task->id); ?>)" class="mr-3 font-semibold text-cyan-700 hover:text-cyan-900">Edit</button>
                            <button type="button" wire:click="deleteTask(<?php echo e($task->id); ?>)" wire:confirm="Delete this task?" class="font-semibold text-red-700 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr><td colspan="4" class="px-6 py-14 text-center text-slate-500">No tasks match this filter.</td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tasks->hasPages()): ?><div class="border-t border-slate-200 px-6 py-4"><?php echo e($tasks->links()); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</section>
<?php /**PATH D:\Projects\task-enterprise-api\resources\views/livewire/task-list.blade.php ENDPATH**/ ?>