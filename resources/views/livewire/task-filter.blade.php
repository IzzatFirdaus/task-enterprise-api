<div class="flex items-center gap-2">
    <label for="task-search" class="sr-only">Search tasks</label>
    <input
        id="task-search"
        type="search"
        wire:model.live.debounce.300ms="search"
        placeholder="Search tasks"
        class="h-10 w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-xs font-medium text-slate-700 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 sm:w-52"
    >
    <label for="task-status-filter" class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 sr-only">Filter by Status</label>
    <div class="relative">
        <select
            id="task-status-filter"
            wire:model.live="status"
            class="h-10 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 py-2 pl-3.5 pr-8 text-xs font-medium text-slate-700 dark:text-slate-200 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20"
        >
            <option value="all">All Tasks</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>
</div>
