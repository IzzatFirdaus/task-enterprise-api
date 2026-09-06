<div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 sm:p-6 shadow-xs">
    <div class="mb-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
        <h3 class="text-base font-bold text-slate-950 dark:text-white">Task overview</h3>
        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Total: {{ $tasks->total() }}</span>
    </div>

    <!-- Loading Skeleton State -->
    <div wire:loading.block wire:target="search,status,gotoPage,previousPage,nextPage" class="py-2" role="status" aria-live="polite">
        <x-skeleton-loader type="table" :rows="4" label="Loading tasks..." />
    </div>

    <!-- Loaded Content -->
    <div wire:loading.remove wire:target="search,status,gotoPage,previousPage,nextPage">
        @if ($tasks->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                    <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <h4 class="mt-4 text-sm font-bold text-slate-950 dark:text-white">No tasks found</h4>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 max-w-sm">No tasks match your selected filter. Create a new task or change the status filter above.</p>
            </div>
        @else
            <!-- Mobile Card Layout -->
            <div class="space-y-3 sm:hidden">
                @foreach ($tasks as $task)
                    <article class="min-w-0 rounded-lg border border-slate-200 dark:border-slate-700 p-4 dark:bg-slate-800/50">
                        <div class="flex min-w-0 items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <h4 class="break-words text-sm font-semibold text-slate-950 dark:text-slate-100">{{ $task->title }}</h4>
                                @if ($task->description)
                                    <p class="mt-1 break-words text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $task->description }}</p>
                                @endif
                            </div>
                            <x-badge type="status" :value="$task->status" size="sm" />
                        </div>
                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                            Created <time datetime="{{ $task->created_at?->toISOString() }}">{{ $task->created_at?->format('M d, Y') ?? 'N/A' }}</time>
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
                            <a
                                href="{{ route('tasks.show', $task) }}"
                                class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-xs hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600"
                                aria-label="View task: {{ $task->title }}"
                            >
                                View
                            </a>
                            <a
                                href="{{ route('tasks.edit', $task) }}"
                                class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-xs hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600"
                                aria-label="Edit task: {{ $task->title }}"
                            >
                                Edit
                            </a>
                            <button
                                type="button"
                                wire:click="deleteTask({{ $task->id }})"
                                wire:confirm="Are you sure you want to delete this task?"
                                class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-rose-300 dark:border-rose-800 bg-white dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-rose-700 dark:text-rose-400 shadow-xs hover:bg-rose-50 dark:hover:bg-rose-950/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-600"
                                aria-label="Delete task: {{ $task->title }}"
                            >
                                Delete
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Desktop Table Layout -->
            <div class="hidden overflow-x-auto sm:block">
                <table class="w-full text-left text-sm" aria-label="Tasks list">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700 text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            <th scope="col" class="pb-3 pr-4">Task details</th>
                            <th scope="col" class="pb-3 px-4">Status</th>
                            <th scope="col" class="pb-3 px-4">Created</th>
                            <th scope="col" class="pb-3 pl-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($tasks as $task)
                            <tr class="group transition hover:bg-slate-50/80 dark:hover:bg-slate-800/50">
                                <!-- Task Details -->
                                <td class="py-3.5 pr-4 align-top">
                                    <div class="font-semibold text-slate-950 dark:text-white">{{ $task->title }}</div>
                                    @if ($task->description)
                                        <div class="mt-0.5 text-xs text-slate-600 dark:text-slate-400 line-clamp-1" title="{{ $task->description }}">
                                            {{ $task->description }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Status Badge -->
                                <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                    <x-badge type="status" :value="$task->status" size="sm" />
                                </td>

                                <!-- Created Date -->
                                <td class="py-3.5 px-4 align-top whitespace-nowrap text-xs font-medium text-slate-600 dark:text-slate-400">
                                    <time datetime="{{ $task->created_at?->toISOString() }}">
                                        {{ $task->created_at?->format('M d, Y') ?? 'N/A' }}
                                    </time>
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 pl-4 align-top text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a
                                            href="{{ route('tasks.show', $task) }}"
                                            class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-1.5 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-xs transition hover:border-teal-400 dark:hover:border-teal-500 hover:bg-teal-50 dark:hover:bg-slate-700 hover:text-teal-900 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600"
                                            aria-label="View task: {{ $task->title }}"
                                        >
                                            View
                                        </a>
                                        <a
                                            href="{{ route('tasks.edit', $task) }}"
                                            class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center gap-1 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-1.5 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-xs transition hover:border-slate-400 dark:hover:border-slate-500 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-950 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600"
                                            aria-label="Edit task: {{ $task->title }}"
                                        >
                                            <svg class="h-3.5 w-3.5 text-slate-500 dark:text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Edit
                                        </a>

                                        <button
                                            type="button"
                                            wire:click="deleteTask({{ $task->id }})"
                                            wire:confirm="Are you sure you want to delete this task?"
                                            class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center gap-1 rounded-lg border border-rose-300 dark:border-rose-800 bg-white dark:bg-slate-800 px-3 py-1.5 text-xs font-semibold text-rose-700 dark:text-rose-400 shadow-xs transition hover:border-rose-400 dark:hover:border-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/50 hover:text-rose-800 dark:hover:text-rose-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-600"
                                            aria-label="Delete task: {{ $task->title }}"
                                        >
                                            <svg class="h-3.5 w-3.5 text-rose-600 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
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
</div>
