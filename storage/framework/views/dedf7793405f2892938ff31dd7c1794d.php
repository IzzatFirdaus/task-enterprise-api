<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($open): ?>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 px-6" role="dialog" aria-modal="true" aria-labelledby="edit-task-title">
            <section class="w-full max-w-lg border border-slate-200 bg-white p-6 shadow-xl">
                <div class="mb-6 flex items-start justify-between"><div><h2 id="edit-task-title" class="text-xl font-semibold text-slate-950">Edit task</h2><p class="mt-1 text-sm text-slate-500">Update the task details and status.</p></div><button type="button" wire:click="close" aria-label="Close" class="text-2xl leading-none text-slate-400 hover:text-slate-900">&times;</button></div>
                <form wire:submit="update" class="space-y-5">
                    <div><label for="edit-title" class="mb-2 block text-sm font-medium text-slate-700">Title</label><input id="edit-title" type="text" wire:model.blur="title" maxlength="255" required class="w-full border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600"><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                    <div><label for="edit-description" class="mb-2 block text-sm font-medium text-slate-700">Description</label><textarea id="edit-description" wire:model.blur="description" rows="4" maxlength="5000" class="w-full border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600"></textarea><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                    <div><label for="edit-status" class="mb-2 block text-sm font-medium text-slate-700">Status</label><select id="edit-status" wire:model="status" class="w-full border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-cyan-600 focus:ring-cyan-600"><option value="pending">Pending</option><option value="in_progress">In progress</option><option value="completed">Completed</option></select></div>
                    <div class="flex justify-between gap-3"><button type="button" wire:click="delete" wire:confirm="Delete this task?" class="border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-50">Delete</button><div class="flex gap-3"><button type="button" wire:click="close" class="border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700">Cancel</button><button type="submit" class="bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-cyan-800">Save changes</button></div></div>
                </form>
            </section>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH D:\Projects\task-enterprise-api\resources\views/livewire/edit-task.blade.php ENDPATH**/ ?>