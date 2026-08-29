<section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" wire:key="task-stats-{{ $refreshToken }}">
    @foreach ([['label' => 'Total tasks', 'value' => $stats['total'], 'color' => 'text-slate-950'], ['label' => 'Pending', 'value' => $stats['pending'], 'color' => 'text-amber-700'], ['label' => 'In progress', 'value' => $stats['in_progress'], 'color' => 'text-cyan-700'], ['label' => 'Completed', 'value' => $stats['completed'], 'color' => 'text-emerald-700']] as $stat)
        <div class="border border-slate-200 bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">{{ $stat['label'] }}</p><p class="mt-2 text-3xl font-semibold {{ $stat['color'] }}">{{ $stat['value'] }}</p></div>
    @endforeach
</section>
