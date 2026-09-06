<div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs">
    <div class="mb-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
        <h3 class="text-base font-bold text-slate-950 dark:text-white">Create task</h3>
        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Your workspace</span>
    </div>

    <form wire:submit="save" class="space-y-4">
        <!-- Title Input -->
        <div class="space-y-1.5">
            <label for="create_title" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                Title <span class="text-rose-600 dark:text-rose-400" aria-hidden="true">*</span>
                <span class="sr-only">(required)</span>
            </label>
            <input
                id="create_title"
                type="text"
                wire:model="title"
                placeholder="e.g. Audit API authentication pipeline"
                required
                aria-required="true"
                @error('title') aria-invalid="true" aria-describedby="create_title_error" @enderror
                class="min-h-[44px] w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-950 dark:text-slate-100 placeholder:text-slate-500 dark:placeholder:text-slate-400 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 focus-visible:border-teal-600"
            />
            @error('title')
                <p id="create_title_error" class="text-xs font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description Input -->
        <div class="space-y-1.5">
            <label for="create_description" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                Description <span class="font-normal text-slate-500 dark:text-slate-400">(optional)</span>
            </label>
            <textarea
                id="create_description"
                wire:model="description"
                rows="3"
                placeholder="Add context, acceptance criteria, or links."
                @error('description') aria-invalid="true" aria-describedby="create_description_error" @enderror
                class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-950 dark:text-slate-100 placeholder:text-slate-500 dark:placeholder:text-slate-400 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 focus-visible:border-teal-600"
            ></textarea>
            @error('description')
                <p id="create_description_error" class="text-xs font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status Select -->
        <div class="space-y-1.5">
            <label for="create_status" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                Initial Status
            </label>
            <select
                id="create_status"
                wire:model="status"
                class="min-h-[44px] w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-950 dark:text-slate-100 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 focus-visible:border-teal-600"
            >
                <option value="pending">Pending</option>
                <option value="in_progress">In progress</option>
                <option value="completed">Completed</option>
            </select>
            @error('status')
                <p class="text-xs font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-teal-700 dark:bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition hover:bg-teal-800 dark:hover:bg-teal-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-900 disabled:opacity-50"
            >
                <svg wire:loading wire:target="save" class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Add task</span>
                <span wire:loading wire:target="save">Adding task...</span>
            </button>
        </div>
    </form>
</div>
