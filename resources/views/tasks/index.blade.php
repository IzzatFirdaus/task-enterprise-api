@extends('layouts.app')

@section('title', 'Tasks')
@section('description', 'Review, filter, and manage your personal tasks in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-cyan-700 dark:text-cyan-400">Personal workload</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Tasks</h1>
                <p class="mt-1 max-w-xl text-sm text-slate-500 dark:text-slate-400">A focused view of the work you own, from intake through completion.</p>
            </div>
            <a href="{{ route('tasks.create') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:bg-cyan-600 dark:hover:bg-cyan-500 dark:focus:ring-offset-slate-900">Create task</a>
        </div>

        <div class="mb-4 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Task queue</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Filter the list to focus your attention.</p>
            </div>
            @livewire('task-filter')
        </div>

        @livewire('task-list')
    </div>
@endsection
