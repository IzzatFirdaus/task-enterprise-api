<div class="flex items-center gap-2">
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
<?php /**PATH D:\Projects\task-enterprise-api\resources\views/livewire/task-filter.blade.php ENDPATH**/ ?>