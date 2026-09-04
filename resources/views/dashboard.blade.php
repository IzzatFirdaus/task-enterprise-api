@extends('layouts.app')

@section('title', 'Dashboard')
@section('description', 'Review your personal task workload, priorities, and progress in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Hero Header -->
        <div class="mb-8 flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center sm:p-8">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-cyan-50 dark:bg-cyan-950/60 px-3 py-1 text-xs font-semibold text-cyan-800 dark:text-cyan-400 ring-1 ring-inset ring-cyan-700/10 dark:ring-cyan-500/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-cyan-600 dark:bg-cyan-400"></span>
                    Operations Workspace
                </div>
                <h1 class="mt-2 text-2xl sm:text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Task Command Center</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 max-w-xl">Organize, track, and advance your daily deliverables with real-time operational oversight.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-400 shadow-xs">
                    <svg class="h-4 w-4 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <span>{{ now()->format('l, M j, Y') }}</span>
                </div>
            </div>
        </div>

        @livewire('task-stats')

        <section class="mt-8 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800 sm:p-8" aria-labelledby="dashboard-next-step">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-cyan-700 dark:text-cyan-400">Personal workspace</p>
                    <h2 id="dashboard-next-step" class="mt-2 text-xl font-bold tracking-tight text-slate-950 dark:text-white">Keep your next deliverable visible.</h2>
                    <p class="mt-1 max-w-xl text-sm text-slate-500 dark:text-slate-400">Open the task queue to filter, create, update, and remove your own work items.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('tasks.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl bg-cyan-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:bg-cyan-600 dark:hover:bg-cyan-500 dark:focus:ring-offset-slate-900">Open task queue</a>
                    <a href="{{ route('tasks.create') }}" class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 dark:focus:ring-offset-slate-900">Create task</a>
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
