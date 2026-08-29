<section class="overflow-hidden border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-6 py-5">
        <h2 class="text-xl font-semibold text-slate-950">Your tasks</h2>
        <p class="mt-1 text-sm text-slate-500">Latest activity first</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-3 font-semibold">Task</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Created</th>
                    <th class="px-6 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($tasks as $task)
                    <tr wire:key="task-{{ $task->id }}" class="hover:bg-slate-50">
                        <td class="max-w-sm px-6 py-4">
                            <p class="font-medium {{ $task->status === 'completed' ? 'text-slate-400 line-through' : 'text-slate-950' }}">{{ $task->title }}</p>
                            @if ($task->description)<p class="mt-1 truncate text-slate-500">{{ $task->description }}</p>@endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4"><span class="px-2 py-1 text-xs font-medium {{ $task->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : ($task->status === 'in_progress' ? 'bg-cyan-50 text-cyan-700' : 'bg-amber-50 text-amber-700') }}">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span></td>
                        <td class="whitespace-nowrap px-6 py-4 text-slate-500">{{ $task->created_at->format('M j, Y') }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <button type="button" wire:click="editTask({{ $task->id }})" class="mr-3 font-semibold text-cyan-700 hover:text-cyan-900">Edit</button>
                            <button type="button" wire:click="deleteTask({{ $task->id }})" wire:confirm="Delete this task?" class="font-semibold text-red-700 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-14 text-center text-slate-500">No tasks match this filter.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($tasks->hasPages())<div class="border-t border-slate-200 px-6 py-4">{{ $tasks->links() }}</div>@endif
</section>
