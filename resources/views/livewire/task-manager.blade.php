<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:p-8">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-800 ring-1 ring-inset ring-cyan-700/10">
                <span class="h-1.5 w-1.5 rounded-full bg-cyan-600"></span>
                Operations Workspace
            </div>
            <h1 class="mt-2 text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">Task Command Center</h1>
            <p class="mt-1 text-sm text-slate-500 max-w-xl">Keep delivery moving with real-time tracking of active deliverables.</p>
        </div>
        <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-semibold text-slate-600">
            <span>{{ now()->format('D, M j, Y') }}</span>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm" role="status">
            <svg class="h-5 w-5 text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([['label' => 'Total tasks', 'value' => $counts['all'], 'color' => 'text-slate-950'], ['label' => 'Pending', 'value' => $counts['pending'], 'color' => 'text-amber-700'], ['label' => 'In progress', 'value' => $counts['in_progress'], 'color' => 'text-cyan-700'], ['label' => 'Completed', 'value' => $counts['completed'], 'color' => 'text-emerald-700']] as $stat)
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs transition hover:border-slate-300 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-bold tracking-tight {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
        <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="mb-4 border-b border-slate-100 pb-3">
                <h2 class="text-base font-semibold text-slate-950">Create a task</h2>
                <p class="text-xs text-slate-500">Add a piece of work to your queue.</p>
            </div>
            <form wire:submit="addTask" class="space-y-4">
                <div class="space-y-1.5">
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Title <span class="text-rose-500">*</span></label>
                    <input id="title" type="text" wire:model.blur="title" maxlength="255" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20" placeholder="e.g. Review release plan">
                    @error('title') <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Description <span class="font-normal text-slate-400">(optional)</span></label>
                    <textarea id="description" wire:model.blur="description" rows="3" maxlength="5000" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20" placeholder="Add context, acceptance criteria, or links."></textarea>
                    @error('description') <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Starting status</label>
                    <select id="status" wire:model="status" class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 disabled:opacity-60">Add task</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="text-base font-semibold text-slate-950">Your tasks</h2>
                    <p class="text-xs text-slate-500">Latest activity first</p>
                </div>
                <span class="text-xs font-medium text-slate-500">{{ $counts['all'] }} total</span>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($tasks as $task)
                    <article wire:key="task-{{ $task->id }}" class="flex flex-col gap-4 py-4 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-medium text-sm {{ $task->status === 'completed' ? 'text-slate-400 line-through' : 'text-slate-900' }}">{{ $task->title }}</h3>
                                <x-badge type="status" :value="$task->status" size="sm" />
                            </div>
                            @if ($task->description)<p class="mt-1.5 text-xs text-slate-500">{{ $task->description }}</p>@endif
                            <p class="mt-2 text-[11px] text-slate-400">Created {{ $task->created_at?->diffForHumans() ?? 'recently' }}</p>
                        </div>
                        <div class="flex shrink-0 gap-1.5">
                            <button type="button" wire:click="toggleStatus({{ $task->id }})" class="rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs font-medium text-slate-700 shadow-2xs hover:bg-slate-50">Advance</button>
                            <button type="button" wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-medium text-rose-600 shadow-2xs hover:bg-rose-50">Delete</button>
                        </div>
                    </article>
                @empty
                    <div class="py-12 text-center">
                        <p class="font-medium text-sm text-slate-900">No tasks yet</p>
                        <p class="mt-1 text-xs text-slate-500">Create your first task to start tracking delivery.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
