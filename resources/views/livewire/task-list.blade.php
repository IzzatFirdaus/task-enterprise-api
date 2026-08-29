<div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
    <div class="mb-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
        <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">Task Overview</h3>
        <span class="text-xs text-slate-400 dark:text-slate-500">Total: {{ $tasks->total() }}</span>
    </div>

    @if ($tasks->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
            </div>
            <h4 class="mt-4 text-sm font-semibold text-slate-900 dark:text-slate-100">No tasks found</h4>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 max-w-sm">No tasks match your selected filter. Create a new task or switch the status filter above.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-700 text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        <th scope="col" class="pb-3 pr-4">Task Details</th>
                        <th scope="col" class="pb-3 px-4">Status</th>
                        <th scope="col" class="pb-3 px-4">Created</th>
                        <th scope="col" class="pb-3 pl-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach ($tasks as $task)
                        <tr class="group transition hover:bg-slate-50/80 dark:hover:bg-slate-700/50">
                            <!-- Task Details -->
                            <td class="py-3.5 pr-4 align-top">
                                <div class="font-medium text-slate-900 dark:text-slate-100">{{ $task->title }}</div>
                                @if ($task->description)
                                    <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 line-clamp-1">{{ $task->description }}</div>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                <x-badge type="status" :value="$task->status" />
                            </td>

                            <!-- Created Date -->
                            <td class="py-3.5 px-4 align-top whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                {{ $task->created_at?->format('M d, Y') ?? 'N/A' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 pl-4 align-top text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button
                                        type="button"
                                        wire:click="$dispatch('open-edit-task-modal', { id: {{ $task->id }} })"
                                        class="inline-flex items-center gap-1 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-2.5 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-300 shadow-2xs transition hover:border-slate-300 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500"
                                        aria-label="Edit task {{ $task->title }}"
                                    >
                                        <svg class="h-3.5 w-3.5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="deleteTask({{ $task->id }})"
                                        wire:confirm="Are you sure you want to delete this task?"
                                        class="inline-flex items-center gap-1 rounded-lg border border-rose-200/80 dark:border-rose-900/60 bg-white dark:bg-slate-800 px-2.5 py-1.5 text-xs font-medium text-rose-600 dark:text-rose-400 shadow-2xs transition hover:border-rose-300 dark:hover:border-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/50 hover:text-rose-700 dark:hover:text-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-500"
                                        aria-label="Delete task {{ $task->title }}"
                                    >
                                        <svg class="h-3.5 w-3.5 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($tasks->hasPages())
            <div class="mt-4 border-t border-slate-100 dark:border-slate-700 pt-4">
                {{ $tasks->links() }}
            </div>
        @endif
    @endif
</div>
