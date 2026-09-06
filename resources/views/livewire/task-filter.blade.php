<div class="flex flex-wrap items-center gap-2">
    <div class="relative flex-1 sm:w-60 sm:flex-initial">
        <label for="task-search" class="sr-only">Search tasks by title or description</label>
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-4 w-4 text-slate-500 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <input
            id="task-search"
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Search tasks..."
            class="min-h-[44px] w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 pl-9 pr-3.5 py-2 text-xs font-semibold text-slate-950 dark:text-slate-100 placeholder:text-slate-500 dark:placeholder:text-slate-400 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 focus-visible:border-teal-600"
        >
    </div>

    <div class="relative">
        <label for="task-status-filter" class="sr-only">Filter by task status</label>
        <select
            id="task-status-filter"
            wire:model.live="status"
            class="min-h-[44px] rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 py-2 pl-3.5 pr-8 text-xs font-semibold text-slate-950 dark:text-slate-100 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 focus-visible:border-teal-600"
        >
            <option value="all">All statuses</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>
</div>
