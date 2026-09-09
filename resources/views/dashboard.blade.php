@extends('layouts.app')

@section('title', 'Dashboard')
@section('description', 'Review your personal task workload, priorities, and progress in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col justify-between gap-4 border-b border-slate-200 pb-6 dark:border-slate-800 sm:flex-row sm:items-end">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Your work, at a glance</h1>
                <p class="mt-2 max-w-xl text-base leading-relaxed text-slate-700 dark:text-slate-300">See what needs attention, move active work forward, and close out completed tasks.</p>
            </div>
            <p class="text-base font-medium text-slate-700 dark:text-slate-300" aria-label="Today's date"><time datetime="{{ now()->toDateString() }}">{{ now()->format('l, M j, Y') }}</time></p>
        </header>

        <!-- Stats Component with Shimmer Loading Support -->
        <div class="mb-8">
            @livewire('task-stats')
        </div>

        <!-- Next Action Card -->
        <section class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs" aria-labelledby="dashboard-next-step">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 id="dashboard-next-step" class="text-xl font-bold tracking-tight text-slate-950 dark:text-white">Open the queue and choose one task</h2>
                    <p class="mt-2 max-w-xl text-base leading-relaxed text-slate-700 dark:text-slate-300">Filter your tasks, update a status, or add a new item with enough context to act on it.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('tasks.index') }}" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl bg-teal-700 px-5 py-3 text-base font-semibold text-white shadow-xs transition duration-150 hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus-visible:ring-offset-slate-950">
                        Open task queue
                    </a>
                    <a href="{{ route('tasks.create') }}" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-base font-semibold text-slate-800 shadow-xs transition duration-150 hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 dark:focus-visible:ring-offset-slate-950">
                        Create task
                    </a>
                </div>
            </div>
        </section>

        <!-- Workspace FAQ Section -->
        <section class="mt-8 max-w-3xl" aria-labelledby="workspace-faq">
            <h2 id="workspace-faq" class="text-xl font-bold tracking-tight text-slate-950 dark:text-white">Workspace FAQ</h2>
            <div class="mt-4 divide-y divide-slate-200 rounded-xl border border-slate-200 bg-white dark:divide-slate-800 dark:border-slate-800 dark:bg-slate-900 shadow-xs">
                <details class="group p-5">
                    <summary class="flex min-h-[44px] cursor-pointer list-none items-center justify-between rounded-lg py-1 text-base font-semibold text-slate-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:text-slate-100">
                        <span>Who can see my tasks?</span>
                        <span class="ml-4 shrink-0 text-slate-500 transition-transform duration-150 group-open:rotate-180 dark:text-slate-400" aria-hidden="true">&darr;</span>
                    </summary>
                    <p class="mt-3 text-base leading-relaxed text-slate-700 dark:text-slate-300">Your personal task views are scoped to your account. Administrative users have a separate moderation workspace.</p>
                </details>
                <details class="group p-5">
                    <summary class="flex min-h-[44px] cursor-pointer list-none items-center justify-between rounded-lg py-1 text-base font-semibold text-slate-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:text-slate-100">
                        <span>What statuses are available?</span>
                        <span class="ml-4 shrink-0 text-slate-500 transition-transform duration-150 group-open:rotate-180 dark:text-slate-400" aria-hidden="true">&darr;</span>
                    </summary>
                    <p class="mt-3 text-base leading-relaxed text-slate-700 dark:text-slate-300">Tasks move through Pending, In Progress, and Completed. You can change the status while creating or editing a task.</p>
                </details>
            </div>
        </section>
    </div>
@endsection
