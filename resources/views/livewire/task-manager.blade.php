<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-10 flex flex-col justify-between gap-6 border-b border-slate-300 pb-8 dark:border-slate-700 sm:flex-row sm:items-end">
        <div>
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.14em] text-teal-700 dark:text-teal-300">Personal work queue</p>
            <h1 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Review your tasks</h1>
            <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300">Manage tasks in your workspace.</p>
        </div>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ now()->format('D, M j, Y') }}</p>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 shadow-sm" role="status">
            <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([['label' => 'Total tasks', 'value' => $counts['all'], 'color' => 'text-slate-950 dark:text-white'], ['label' => 'Pending', 'value' => $counts['pending'], 'color' => 'text-amber-700 dark:text-amber-400'], ['label' => 'In progress', 'value' => $counts['in_progress'], 'color' => 'text-cyan-700 dark:text-cyan-400'], ['label' => 'Completed', 'value' => $counts['completed'], 'color' => 'text-emerald-700 dark:text-emerald-400']] as $stat)
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-bold tracking-tight {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
        <section class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="mb-4 border-b border-slate-100 dark:border-slate-700 pb-3">
                <h2 class="text-base font-semibold text-slate-950 dark:text-white">Create a task</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Add a piece of work to your queue.</p>
            </div>
            <form wire:submit="addTask" class="space-y-4">
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Title <span class="text-rose-500">*</span></label>
                    <input id="title" type="text" wire:model.blur="title" maxlength="255" required class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20" placeholder="e.g. Review release plan">
                    @error('title') <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Description <span class="font-normal text-slate-400 dark:text-slate-500">(optional)</span></label>
                    <textarea id="description" wire:model.blur="description" rows="3" maxlength="5000" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20" placeholder="Add context, acceptance criteria, or links."></textarea>
                    @error('description') <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Starting status</label>
                    <select id="status" wire:model="status" class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-cyan-500 dark:focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:focus:ring-cyan-400/20">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-700 dark:bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-800 dark:hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 disabled:opacity-60">Add task</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <div>
                    <h2 class="text-base font-semibold text-slate-950 dark:text-white">Your tasks</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Latest activity first</p>
                </div>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $counts['all'] }} total</span>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700" wire:loading.class="opacity-50" aria-busy="true" aria-label="Loading tasks">
                <div wire:loading class="animate-pulse space-y-4 py-4">
                    @foreach (range(1, 3) as $i)
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0 flex-1 space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                    <div class="h-4 w-48 rounded bg-slate-200 dark:bg-slate-700"></div>
                                </div>
                                <div class="h-3 w-72 rounded bg-slate-200 dark:bg-slate-700"></div>
                                <div class="h-3 w-32 rounded bg-slate-200 dark:bg-slate-700"></div>
                            </div>
                            <div class="flex shrink-0 gap-1.5">
                                <div class="h-7 w-16 rounded-lg bg-slate-200 dark:bg-slate-700"></div>
                                <div class="h-7 w-16 rounded-lg bg-slate-200 dark:bg-slate-700"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @forelse ($tasks as $task)
                    <article wire:key="task-{{ $task->id }}" class="flex flex-col gap-4 py-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-medium text-sm {{ $task->status === 'completed' ? 'text-slate-400 dark:text-slate-500 line-through' : 'text-slate-900 dark:text-slate-100' }}">{{ $task->title }}</h3>
                                <x-badge type="status" :value="$task->status" size="sm" />
                            </div>
                            @if ($task->description)<p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">{{ $task->description }}</p>@endif
                            <p class="mt-2 text-[11px] text-slate-400 dark:text-slate-500">Created {{ $task->created_at?->diffForHumans() ?? 'recently' }}</p>
                        </div>
                        <div class="flex shrink-0 gap-1.5">
                            <button type="button" wire:click="toggleStatus({{ $task->id }})" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-2.5 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-200 shadow-2xs hover:bg-slate-50 dark:hover:bg-slate-600">Advance</button>
                            <button type="button" wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="rounded-lg border border-rose-200 dark:border-rose-900/60 bg-white dark:bg-slate-700 px-2.5 py-1.5 text-xs font-medium text-rose-600 dark:text-rose-400 shadow-2xs hover:bg-rose-50 dark:hover:bg-rose-950/50">Delete</button>
                        </div>
                    </article>
                @empty
                    <div class="py-12 text-center">
                        <p class="font-medium text-sm text-slate-900 dark:text-slate-100">No tasks yet</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Create your first task to get started.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
