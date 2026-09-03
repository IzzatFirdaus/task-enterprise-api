<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <!-- Header with Breadcrumb -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <nav class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="hover:text-slate-900 dark:hover:text-white transition">User Management</a>
                    <span>/</span>
                    <span class="font-medium text-slate-900 dark:text-slate-100">Edit User</span>
                </nav>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950 dark:text-white">Edit User: <?php echo e($user->name); ?></h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 shadow-2xs hover:bg-slate-50 dark:hover:bg-slate-700">
                    &larr; Back to Users
                </a>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Section 1: User Details -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">User Identity</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Core identity and contact information.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Full Name <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="name"
                            value="<?php echo e(old('name', $user->name)); ?>"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20"
                            required
                        />
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Email Address <span class="text-rose-500">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="<?php echo e(old('email', $user->email)); ?>"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20"
                            required
                        />
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Section 2: Role Assignment -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Role Permissions</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Assign role access levels and capability policies.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 dark:border-slate-700 p-4 transition hover:border-slate-300 dark:hover:border-slate-600 hover:bg-slate-50/50 dark:hover:bg-slate-700/40 has-checked:border-cyan-600 dark:has-checked:border-cyan-500 has-checked:bg-cyan-50/40 dark:has-checked:bg-cyan-950/40">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="<?php echo e($role->id); ?>"
                                <?php echo e(in_array($role->id, old('roles', $user->roles->pluck('id')->all()), false) ? 'checked' : ''); ?>

                                class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 text-cyan-700 dark:text-cyan-500 focus:ring-cyan-500"
                            />
                            <div>
                                <div class="text-sm font-semibold text-slate-900 dark:text-slate-100"><?php echo e(ucfirst(str_replace('_', ' ', $role->name))); ?></div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400">Access role</div>
                            </div>
                        </label>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['roles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['roles.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Section 3: Account Status & Suspension -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Account Access Status</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Temporarily suspend account access or restore active standing.</p>
                </div>

                <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-900/60 p-4 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_suspended"
                            value="1"
                            <?php echo e(old('is_suspended', $user->is_suspended) ? 'checked' : ''); ?>

                            class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 text-rose-600 focus:ring-rose-500"
                        />
                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">Suspend Account Access</span>
                    </label>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Suspension Reason</label>
                        <textarea
                            name="suspension_reason"
                            rows="2"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3.5 py-2 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20"
                            placeholder="Provide administrative notes for this suspension..."
                        ><?php echo e(old('suspension_reason', $user->suspension_reason)); ?></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['suspension_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-200 shadow-2xs hover:bg-slate-50 dark:hover:bg-slate-700">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 dark:bg-cyan-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700 dark:hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-slate-900 dark:focus:ring-cyan-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Projects\task-enterprise-api\resources\views\admin\users\edit.blade.php ENDPATH**/ ?>