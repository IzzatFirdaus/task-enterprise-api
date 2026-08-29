<div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
    <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
        <h3 class="text-base font-semibold text-slate-900">Create New Task</h3>
        <span class="text-xs text-slate-400">Personal Workload</span>
    </div>

    <form wire:submit="save" class="space-y-4">
        <!-- Title Input -->
        <div class="space-y-1.5">
            <label for="create_title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">
                Title <span class="text-rose-500">*</span>
            </label>
            <input
                id="create_title"
                type="text"
                wire:model="title"
                placeholder="e.g. Audit API authentication pipeline"
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
            />
            @error('title')
                <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description Input -->
        <div class="space-y-1.5">
            <label for="create_description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">
                Description
            </label>
            <textarea
                id="create_description"
                wire:model="description"
                rows="3"
                placeholder="Add operational notes or acceptance criteria..."
                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
            ></textarea>
            @error('description')
                <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status Select -->
        <div class="space-y-1.5">
            <label for="create_status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">
                Initial Status
            </label>
            <select
                id="create_status"
                wire:model="status"
                class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
            >
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            @error('status')
                <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 disabled:opacity-50"
            >
                <svg wire:loading wire:target="save" class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Add Task</span>
                <span wire:loading wire:target="save">Adding Task...</span>
            </button>
        </div>
    </form>
</div>
