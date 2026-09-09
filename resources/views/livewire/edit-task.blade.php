<div>
    @if ($isOpen)
        <div
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            x-data="{
                focusables() {
                    const selector = 'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]):not([type=hidden]), select:not([disabled]), [tabindex]:not([tabindex=\\'-1\\'])';
                    return [...$el.querySelectorAll(selector)];
                },
                firstFocusable() { return this.focusables()[0]; },
                lastFocusable() { return this.focusables().slice(-1)[0]; },
                trap(event) {
                    if (event.key !== 'Tab') return;
                    const focusables = this.focusables();
                    if (focusables.length === 0) return;
                    const first = focusables[0];
                    const last = focusables[focusables.length - 1];
                    if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
                    else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
                },
            }"
            x-init="$nextTick(() => firstFocusable()?.focus()); document.body.classList.add('overflow-hidden');"
            x-on:keydown.escape.window.prevent="$wire.close()"
            x-on:keydown.tab="trap($event)"
            x-on:close.stop="$wire.close()"
            wire:key="edit-task-modal"
        >
            <!-- Backdrop -->
            <div
                class="fixed inset-0 bg-slate-950/70 transition-opacity"
                wire:click="close"
                aria-hidden="true"
            ></div>

            <!-- Modal Container -->
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative w-full max-w-lg transform overflow-hidden rounded-xl border border-slate-200 bg-white text-left shadow-xl transition-all dark:border-slate-700 dark:bg-slate-900 sm:my-8"
                >
                    <!-- Header -->
                    <div class="flex items-start justify-between gap-3 border-b border-slate-100 px-6 py-4 dark:border-slate-800">
                        <div>
                            <h3 class="text-base font-bold text-slate-950 dark:text-white" id="modal-title">Edit task</h3>
                            <p class="mt-1 text-base leading-relaxed text-slate-600 dark:text-slate-300">Update the task details below.</p>
                        </div>
                        <button
                            type="button"
                            wire:click="close"
                            class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600"
                            aria-label="Close edit task dialog"
                        >
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Form Body -->
                    <form wire:submit="update" class="space-y-4 px-6 py-5">
                        <!-- Title Input -->
                        <div class="space-y-1.5">
                            <label for="edit_title" class="block text-sm font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Title <span class="text-rose-600 dark:text-rose-400" aria-hidden="true">*</span>
                                <span class="sr-only">(required)</span>
                            </label>
                            <input
                                id="edit_title"
                                type="text"
                                wire:model="title"
                                required
                                aria-required="true"
                                @error('title') aria-invalid="true" aria-describedby="edit_title_error" @enderror
                                class="min-h-[44px] w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-base leading-relaxed text-slate-950 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:border-teal-600 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:focus-visible:ring-teal-400"
                            />
                            @error('title')
                                <p id="edit_title_error" class="text-sm font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Input -->
                        <div class="space-y-1.5">
                            <label for="edit_description" class="block text-sm font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Description <span class="font-normal text-slate-500 dark:text-slate-400">(optional)</span>
                            </label>
                            <textarea
                                id="edit_description"
                                wire:model="description"
                                rows="3"
                                aria-describedby="edit_description_help"
                                @error('description') aria-invalid="true" aria-describedby="edit_description_error" @enderror
                                class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-base leading-relaxed text-slate-950 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:border-teal-600 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:focus-visible:ring-teal-400"
                            ></textarea>
                            <p id="edit_description_help" class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">Add context, acceptance criteria, or links to help you act on this task.</p>
                            @error('description')
                                <p id="edit_description_error" class="text-sm font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Select -->
                        <div class="space-y-1.5">
                            <label for="edit_status" class="block text-sm font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Status
                            </label>
                            <select
                                id="edit_status"
                                wire:model="status"
                                @error('status') aria-invalid="true" aria-describedby="edit_status_error" @enderror
                                class="min-h-[44px] w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-base leading-relaxed text-slate-950 shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:border-teal-600 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:focus-visible:ring-teal-400"
                            >
                                <option value="pending">Pending</option>
                                <option value="in_progress">In progress</option>
                                <option value="completed">Completed</option>
                            </select>
                            @error('status')
                                <p id="edit_status_error" class="text-sm font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Modal Footer Actions -->
                        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5 dark:border-slate-800">
                            <button
                                type="button"
                                wire:click="deleteTask"
                                wire:confirm="Are you sure you want to permanently delete this task?"
                                class="inline-flex min-h-[44px] min-w-[44px] items-center gap-2 rounded-xl border border-rose-300 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-600 dark:border-rose-800 dark:bg-rose-950/50 dark:text-rose-300 dark:hover:bg-rose-900/60"
                            >
                                <svg class="h-4 w-4 text-rose-600 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                Delete task
                            </button>

                            <div class="flex flex-wrap items-center gap-2">
                                <button
                                    type="button"
                                    wire:click="close"
                                    class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-800 shadow-xs hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center gap-2 rounded-xl bg-teal-700 px-4 py-2 text-sm font-semibold text-white shadow-xs transition hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 disabled:opacity-50 dark:bg-teal-600 dark:hover:bg-teal-500"
                                >
                                    <svg wire:loading wire:target="update" class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="update">Save changes</span>
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
