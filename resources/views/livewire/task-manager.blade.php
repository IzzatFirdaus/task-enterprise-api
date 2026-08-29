<div class="mx-auto max-w-7xl px-6 py-10 lg:px-10">
    <div class="mb-10 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
        <div>
            <p class="mb-2 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-700">Operations workspace</p>
            <h1 class="text-4xl font-semibold tracking-tight text-slate-950">Task command center</h1>
            <p class="mt-2 max-w-xl text-slate-600">Keep delivery moving with a clear view of active work.</p>
        </div>
        <div class="text-sm text-slate-500">{{ now()->format('D, M j, Y') }}</div>
    </div>

    @if (session('success'))
        <div class="mb-6 border-l-4 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">{{ session('success') }}</div>
    @endif

    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([['label' => 'Total tasks', 'value' => $counts['all'], 'color' => 'text-slate-950'], ['label' => 'Pending', 'value' => $counts['pending'], 'color' => 'text-amber-700'], ['label' => 'In progress', 'value' => $counts['in_progress'], 'color' => 'text-cyan-700'], ['label' => 'Completed', 'value' => $counts['completed'], 'color' => 'text-emerald-700']] as $stat)
            <div class="border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-semibold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-8 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)]">
        <section class="border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-slate-950">Create a task</h2>
                <p class="mt-1 text-sm text-slate-500">Add a piece of work to your queue.</p>
            </div>
            <form wire:submit="addTask" class="space-y-5">
                <div>
                    <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Title</label>
                    <input id="title" type="text" wire:model.blur="title" maxlength="255" required class="w-full border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-cyan-600 focus:ring-cyan-600" placeholder="e.g. Review release plan">
                    @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description <span class="font-normal text-slate-400">(optional)</span></label>
                    <textarea id="description" wire:model.blur="description" rows="4" maxlength="5000" class="w-full border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-cyan-600 focus:ring-cyan-600" placeholder="Add context, acceptance criteria, or links."></textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="status" class="mb-2 block text-sm font-medium text-slate-700">Starting status</label>
                    <select id="status" wire:model="status" class="w-full border-slate-300 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-cyan-600 focus:ring-cyan-600">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <button type="submit" wire:loading.attr="disabled" class="w-full bg-slate-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-cyan-800 disabled:cursor-wait disabled:opacity-60">Add task</button>
            </form>
        </section>

        <section class="border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                <div>
                    <h2 class="text-xl font-semibold text-slate-950">Your tasks</h2>
                    <p class="mt-1 text-sm text-slate-500">Latest activity first</p>
                </div>
                <span class="text-sm font-medium text-slate-500">{{ $counts['all'] }} total</span>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($tasks as $task)
                    <article wire:key="task-{{ $task->id }}" class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-start sm:justify-between">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-medium {{ $task->status === 'completed' ? 'text-slate-400 line-through' : 'text-slate-950' }}">{{ $task->title }}</h3>
                                <span class="px-2 py-1 text-xs font-medium {{ $task->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : ($task->status === 'in_progress' ? 'bg-cyan-50 text-cyan-700' : 'bg-amber-50 text-amber-700') }}">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span>
                            </div>
                            @if ($task->description)<p class="mt-2 text-sm leading-6 text-slate-500">{{ $task->description }}</p>@endif
                            <p class="mt-3 text-xs text-slate-400">Created {{ $task->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex shrink-0 gap-2">
                            <button type="button" wire:click="toggleStatus({{ $task->id }})" class="border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:border-cyan-600 hover:text-cyan-700">Advance</button>
                            <button type="button" wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="border border-red-200 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-14 text-center">
                        <p class="font-medium text-slate-900">No tasks yet</p>
                        <p class="mt-1 text-sm text-slate-500">Create your first task to start tracking delivery.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>
