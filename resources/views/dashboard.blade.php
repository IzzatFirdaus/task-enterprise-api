@extends('layouts.app')

@section('title', 'Dashboard')
@section('description', 'Review your personal task workload, priorities, and progress in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col justify-between gap-6 border-b border-slate-300 pb-8 dark:border-slate-700 sm:flex-row sm:items-end">
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.14em] text-teal-700 dark:text-teal-300">Personal work queue</p>
                <h1 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Your work, at a glance</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300">See what needs attention, move active work forward, and close out completed tasks.</p>
            </div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ now()->format('l, M j, Y') }}</p>
        </div>

        @livewire('task-stats')

        <section class="mt-10 border-y border-slate-300 py-8 dark:border-slate-700" aria-labelledby="dashboard-next-step">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-slate-500 dark:text-slate-400">Next action</p>
                    <h2 id="dashboard-next-step" class="mt-2 text-xl font-bold tracking-tight text-slate-950 dark:text-white">Open the queue and choose one task.</h2>
                    <p class="mt-1 max-w-xl text-sm text-slate-600 dark:text-slate-300">Filter your tasks, update a status, or add a new item with enough context to act on it.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tasks.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-md bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white transition-colors duration-150 hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus:ring-offset-slate-950">Open task queue</a>
                    <a href="{{ route('tasks.create') }}" class="inline-flex min-h-11 items-center justify-center rounded-md border border-slate-400 bg-transparent px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors duration-150 hover:border-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 dark:border-slate-600 dark:text-slate-200 dark:hover:border-slate-400 dark:hover:bg-slate-800 dark:focus:ring-offset-slate-950">Create task</a>
                </div>
            </div>
        </section>

        <section class="mt-8 max-w-3xl" aria-labelledby="workspace-faq">
            <h2 id="workspace-faq" class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Workspace FAQ</h2>
            <div class="mt-3 divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white dark:divide-slate-700 dark:border-slate-800 dark:bg-slate-800">
                <details class="group p-5">
                    <summary class="cursor-pointer list-none font-semibold text-slate-900 marker:hidden dark:text-slate-100">Who can see my tasks?</summary>
                    <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">Your personal task views are scoped to your account. Administrative users have a separate moderation workspace.</p>
                </details>
                <details class="group border-t border-slate-200 p-5 dark:border-slate-700">
                    <summary class="cursor-pointer list-none font-semibold text-slate-900 marker:hidden dark:text-slate-100">What statuses are available?</summary>
                    <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">Tasks move through Pending, In Progress, and Completed. You can change the status while creating or editing a task.</p>
                </details>
            </div>
        </section>
    </div>
@endsection
