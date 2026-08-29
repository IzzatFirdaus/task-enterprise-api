<div>
    @if ($isOpen)
        <div
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <!-- Backdrop -->
            <div
                class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
                wire:click="close"
                aria-hidden="true"
            ></div>

            <!-- Modal Container -->
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    @keydown.escape.window="$wire.close()"
                >
                    <!-- Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-900" id="modal-title">Edit Task Deliverable</h3>
                            <p class="text-xs text-slate-500">Update parameters, scope, or lifecycle stage.</p>
                        </div>
                        <button
                            type="button"
                            wire:click="close"
                            class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500"
                            aria-label="Close modal"
                        >
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Body -->
                    <form wire:submit="update" class="px-6 py-5 space-y-4">
                        <!-- Title Input -->
                        <div class="space-y-1.5">
                            <label for="edit_title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">
                                Title <span class="text-rose-500">*</span>
                            </label>
                            <input
                                id="edit_title"
                                type="text"
                                wire:model="title"
                                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                            />
                            @error('title')
                                <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Input -->
                        <div class="space-y-1.5">
                            <label for="edit_description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">
                                Description
                            </label>
                            <textarea
                                id="edit_description"
                                wire:model="description"
                                rows="3"
                                class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                            ></textarea>
                            @error('description')
                                <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Select -->
                        <div class="space-y-1.5">
                            <label for="edit_status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">
                                Lifecycle Status
                            </label>
                            <select
                                id="edit_status"
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

                        <!-- Modal Footer Actions -->
                        <div class="flex items-center justify-between border-t border-slate-100 pt-4 mt-6">
                            <button
                                type="button"
                                wire:click="deleteTask"
                                wire:confirm="Are you sure you want to permanently delete this task?"
                                class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100 hover:border-rose-300"
                            >
                                <svg class="h-3.5 w-3.5 text-rose-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                Delete
                            </button>

                            <div class="flex items-center gap-2">
                                <button
                                    type="button"
                                    wire:click="close"
                                    class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-700 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 disabled:opacity-50"
                                >
                                    <svg wire:loading wire:target="update" class="h-3.5 w-3.5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="update">Save Changes</span>
                                    <span wire:loading wire:target="update">Saving...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
