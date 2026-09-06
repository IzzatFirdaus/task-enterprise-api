<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <header class="mb-8 flex flex-col justify-between gap-4 border-b border-slate-200 pb-6 dark:border-slate-800 sm:flex-row sm:items-end">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-3xl">Review your tasks</h1>
            <p class="mt-1 max-w-xl text-sm leading-6 text-slate-700 dark:text-slate-300">Manage, advance, and organize tasks in your workspace.</p>
        </div>
        <p class="text-sm font-medium text-slate-600 dark:text-slate-400" aria-label="Current date">{{ now()->format('D, M j, Y') }}</p>
    </header>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-300 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/40 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 shadow-xs" role="status" aria-live="polite">
            <svg class="h-5 w-5 shrink-0 text-emerald-700 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Metric Stat Cards -->
    <section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" aria-label="Task metrics summary">
        @foreach ([
            ['label' => 'Total tasks', 'value' => $counts['all'], 'color' => 'text-slate-950 dark:text-white'],
            ['label' => 'Pending', 'value' => $counts['pending'], 'color' => 'text-amber-700 dark:text-amber-400'],
            ['label' => 'In progress', 'value' => $counts['in_progress'], 'color' => 'text-teal-700 dark:text-teal-400'],
            ['label' => 'Completed', 'value' => $counts['completed'], 'color' => 'text-emerald-700 dark:text-emerald-400']
        ] as $stat)
            <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xs transition duration-150">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-bold tracking-tight {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </section>

    <!-- Main Content Grid -->
    <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
        <!-- Create Task Form Section -->
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs" aria-labelledby="create-task-heading">
            <div class="mb-5 border-b border-slate-100 dark:border-slate-700 pb-3">
                <h2 id="create-task-heading" class="text-base font-bold text-slate-950 dark:text-white">Create a task</h2>
                <p class="text-xs text-slate-600 dark:text-slate-400">Add a piece of work to your queue.</p>
            </div>
            <form wire:submit="addTask" class="space-y-4">
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Title <span class="text-rose-600 dark:text-rose-400" aria-hidden="true">*</span>
                        <span class="sr-only">(required)</span>
                    </label>
                    <input
                        id="title"
                        type="text"
                        wire:model.blur="title"
                        maxlength="255"
                        required
                        aria-required="true"
                        @error('title') aria-invalid="true" aria-describedby="title-error" @enderror
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-950 dark:text-slate-100 shadow-xs focus-visible:border-teal-600 focus-visible:ring-2 focus-visible:ring-teal-600/30 focus:outline-none"
                        placeholder="e.g. Review release plan"
                    >
                    @error('title')
                        <p id="title-error" class="text-xs font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Description <span class="font-normal text-slate-500 dark:text-slate-400">(optional)</span>
                    </label>
                    <textarea
                        id="description"
                        wire:model.blur="description"
                        rows="3"
                        maxlength="5000"
                        @error('description') aria-invalid="true" aria-describedby="description-error" @enderror
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-950 dark:text-slate-100 shadow-xs focus-visible:border-teal-600 focus-visible:ring-2 focus-visible:ring-teal-600/30 focus:outline-none"
                        placeholder="Add context, acceptance criteria, or links."
                    ></textarea>
                    @error('description')
                        <p id="description-error" class="text-xs font-semibold text-rose-700 dark:text-rose-400" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                        Starting status
                    </label>
                    <select
                        id="status"
                        wire:model="status"
                        class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-950 dark:text-slate-100 shadow-xs focus-visible:border-teal-600 focus-visible:ring-2 focus-visible:ring-teal-600/30 focus:outline-none"
                    >
                        <option value="pending">Pending</option>
                        <option value="in_progress">In progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl bg-teal-700 dark:bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition hover:bg-teal-800 dark:hover:bg-teal-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-900 disabled:opacity-60"
                    >
                        <svg wire:loading wire:target="addTask" class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="addTask">Add task</span>
                        <span wire:loading wire:target="addTask">Adding task...</span>
                    </button>
                </div>
            </form>
        </section>

        <!-- Tasks Queue Section -->
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs" aria-labelledby="task-queue-heading">
            <div class="mb-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <div>
                    <h2 id="task-queue-heading" class="text-base font-bold text-slate-950 dark:text-white">Your tasks</h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400">Latest activity first</p>
                </div>
                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $counts['all'] }} total</span>
            </div>

            <!-- Loading Skeleton State -->
            <div wire:loading wire:target="addTask,toggleStatus,deleteTask" class="py-2">
                <x-skeleton-loader type="list" :rows="3" label="Updating tasks list..." />
            </div>

            <!-- Task List Container -->
            <div wire:loading.remove wire:target="addTask,toggleStatus,deleteTask" class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($tasks as $task)
                    <article wire:key="task-{{ $task->id }}" class="flex flex-col gap-3 py-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-sm font-semibold {{ $task->status === 'completed' ? 'text-slate-500 dark:text-slate-400 line-through' : 'text-slate-950 dark:text-slate-100' }}">
                                    {{ $task->title }}
                                </h3>
                                <x-badge type="status" :value="$task->status" size="sm" />
                            </div>
                            @if ($task->description)
                                <p class="mt-1.5 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $task->description }}</p>
                            @endif
                            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                                Created <time datetime="{{ $task->created_at?->toISOString() }}">{{ $task->created_at?->diffForHumans() ?? 'recently' }}</time>
                            </p>
                        </div>
                        <div class="flex shrink-0 items-center gap-2 pt-1">
                            <button
                                type="button"
                                wire:click="toggleStatus({{ $task->id }})"
                                class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-xs hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-950 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600"
                                aria-label="Advance status for task: {{ $task->title }}"
                            >
                                Advance
                            </button>
                            <button
                                type="button"
                                wire:click="deleteTask({{ $task->id }})"
                                wire:confirm="Are you sure you want to delete this task?"
                                class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-rose-300 dark:border-rose-800 bg-white dark:bg-slate-800 px-3 py-2 text-xs font-semibold text-rose-700 dark:text-rose-400 shadow-xs hover:bg-rose-50 dark:hover:bg-rose-950/50 hover:text-rose-800 dark:hover:text-rose-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-600"
                                aria-label="Delete task: {{ $task->title }}"
                            >
                                Delete
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-slate-950 dark:text-slate-100">No tasks in your queue</p>
                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-400">Create your first task on the left to get started.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
