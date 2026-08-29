<div class="flex items-center gap-2">
    <label for="task-status-filter" class="text-xs font-semibold uppercase tracking-wider text-slate-500 sr-only">Filter by Status</label>
    <div class="relative">
        <select
            id="task-status-filter"
            wire:model.live="status"
            class="h-10 rounded-xl border border-slate-300 bg-white py-2 pl-3.5 pr-8 text-xs font-medium text-slate-700 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
        >
            <option value="all">All Tasks</option>
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>
    </div>
</div>
