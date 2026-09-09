@extends('layouts.app')

@section('title', 'Tasks')
@section('description', 'Review, filter, and manage your personal tasks in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col justify-between gap-4 border-b border-slate-200 pb-6 dark:border-slate-800 sm:flex-row sm:items-end">
            <div>
                <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">Personal workload</p>
                <h1 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Tasks</h1>
                <p class="mt-2 max-w-xl text-base leading-relaxed text-slate-700 dark:text-slate-300">A focused view of the work you own, from intake through completion.</p>
            </div>
            <a href="{{ route('tasks.create') }}" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl bg-teal-700 px-5 py-3 text-base font-semibold text-white shadow-xs transition hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus-visible:ring-offset-slate-950">
                Create task
            </a>
        </header>

        <section class="mb-5 flex flex-col justify-between gap-3 sm:flex-row sm:items-center" aria-label="Task queue filters">
            <div>
                <h2 class="text-lg font-bold tracking-tight text-slate-950 dark:text-white">Task queue</h2>
                <p class="text-base leading-relaxed text-slate-700 dark:text-slate-300">Filter the list to focus your attention.</p>
            </div>
            @livewire('task-filter')
        </section>

        @livewire('task-list')
    </div>
@endsection
