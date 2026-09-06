<div wire:key="task-stats-{{ $refreshToken }}">
    <!-- Loading Skeleton during async poll/refresh -->
    <div wire:loading.block wire:target="$refresh,refreshToken" class="py-1">
        <x-skeleton-loader type="stats" label="Updating statistics..." />
    </div>

    <!-- Active Stats Grid -->
    <section wire:loading.remove wire:target="$refresh,refreshToken" class="grid divide-y divide-slate-200 dark:divide-slate-800 border-y border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 sm:grid-cols-2 sm:divide-y-0 sm:divide-x lg:grid-cols-4" aria-label="Task status summary">
        <!-- Total Tasks -->
        <div class="p-5 sm:p-6">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Total Tasks</span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white">{{ $stats['total'] }}</span>
                <span class="text-xs font-medium text-slate-600 dark:text-slate-400">tasks</span>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="p-5 sm:p-6">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-400">Pending</span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold tracking-tight text-amber-800 dark:text-amber-400">{{ $stats['pending'] }}</span>
                <span class="text-xs font-medium text-amber-800 dark:text-amber-400">not started</span>
            </div>
        </div>

        <!-- In Progress Tasks -->
        <div class="p-5 sm:p-6">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-800 dark:text-teal-400">In Progress</span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold tracking-tight text-teal-800 dark:text-teal-400">{{ $stats['in_progress'] }}</span>
                <span class="text-xs font-medium text-teal-800 dark:text-teal-400">active</span>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="p-5 sm:p-6">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800 dark:text-emerald-400">Completed</span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-bold tracking-tight text-emerald-800 dark:text-emerald-400">{{ $stats['completed'] }}</span>
                <span class="text-xs font-medium text-emerald-800 dark:text-emerald-400">completed</span>
            </div>
        </div>
    </section>
</div>
