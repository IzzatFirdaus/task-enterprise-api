<section class="grid border-y border-slate-300 bg-white dark:border-slate-700 dark:bg-slate-900 sm:grid-cols-2 lg:grid-cols-4" wire:key="task-stats-{{ $refreshToken }}" aria-label="Task status summary">
    <!-- Total Tasks -->
    <div class="border-b border-slate-200 p-5 dark:border-slate-700 sm:border-r lg:border-b-0">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Tasks</span>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $stats['total'] }}</span>
            <span class="text-xs text-slate-400 dark:text-slate-500">tasks</span>
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="border-b border-slate-200 p-5 dark:border-slate-700 sm:border-r lg:border-b-0">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">Pending</span>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-amber-700 dark:text-amber-400">{{ $stats['pending'] }}</span>
            <span class="text-xs text-amber-700 dark:text-amber-500">not started</span>
        </div>
    </div>

    <!-- In Progress Tasks -->
    <div class="border-b border-slate-200 p-5 dark:border-slate-700 lg:border-r lg:border-b-0">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-cyan-700 dark:text-cyan-400">In Progress</span>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-cyan-700 dark:text-cyan-400">{{ $stats['in_progress'] }}</span>
            <span class="text-xs text-cyan-700 dark:text-cyan-500">in progress</span>
        </div>
    </div>

    <!-- Completed Tasks -->
    <div class="p-5">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Completed</span>
        </div>
        <div class="mt-4 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-emerald-700 dark:text-emerald-400">{{ $stats['completed'] }}</span>
            <span class="text-xs text-emerald-700 dark:text-emerald-500">completed</span>
        </div>
    </div>
</section>
