@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10 lg:px-10">
        <div class="mb-10 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="mb-2 text-sm font-semibold uppercase tracking-[0.2em] text-cyan-700">Operations workspace</p>
                <h1 class="text-4xl font-semibold tracking-tight text-slate-950">Task command center</h1>
                <p class="mt-2 max-w-xl text-slate-600">Keep delivery moving with a clear view of active work.</p>
            </div>
            <div class="text-sm text-slate-500">{{ now()->format('D, M j, Y') }}</div>
        </div>

        @livewire('task-stats')

        <div class="mb-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <h2 class="text-2xl font-semibold text-slate-950">Work queue</h2>
            @livewire('task-filter')
        </div>

        <div class="grid gap-8 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)]">
            @livewire('create-task')
            @livewire('task-list')
        </div>
    </div>

    @livewire('edit-task')
@endsection
