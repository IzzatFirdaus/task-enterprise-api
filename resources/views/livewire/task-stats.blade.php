<section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" wire:key="task-stats-{{ $refreshToken }}">
    <!-- Total Tasks -->
    <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-md">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Tasks</span>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 transition group-hover:scale-105">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $stats['total'] }}</span>
            <span class="text-xs text-slate-400 dark:text-slate-500">active workload</span>
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="group relative overflow-hidden rounded-2xl border border-amber-200/80 dark:border-amber-900/60 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-amber-300 dark:hover:border-amber-700 hover:shadow-md">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-700 dark:text-amber-400">Pending</span>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 transition group-hover:scale-105">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-amber-700 dark:text-amber-400">{{ $stats['pending'] }}</span>
            <span class="text-xs text-amber-600/70 dark:text-amber-500/70">awaiting start</span>
        </div>
    </div>

    <!-- In Progress Tasks -->
    <div class="group relative overflow-hidden rounded-2xl border border-cyan-200/80 dark:border-cyan-900/60 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-cyan-300 dark:hover:border-cyan-700 hover:shadow-md">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-cyan-700 dark:text-cyan-400">In Progress</span>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 transition group-hover:scale-105">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-cyan-700 dark:text-cyan-400">{{ $stats['in_progress'] }}</span>
            <span class="text-xs text-cyan-600/70 dark:text-cyan-500/70">under delivery</span>
        </div>
    </div>

    <!-- Completed Tasks -->
    <div class="group relative overflow-hidden rounded-2xl border border-emerald-200/80 dark:border-emerald-900/60 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-md">
        <div class="flex items-center justify-between">
            <span class="text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Completed</span>
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 transition group-hover:scale-105">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="mt-3 flex items-baseline gap-2">
            <span class="text-3xl font-bold tracking-tight text-emerald-700 dark:text-emerald-400">{{ $stats['completed'] }}</span>
            <span class="text-xs text-emerald-600/70 dark:text-emerald-500/70">accomplished</span>
        </div>
    </div>
</section>
