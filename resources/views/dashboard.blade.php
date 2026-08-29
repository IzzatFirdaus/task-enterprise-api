@extends('layouts.app')

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

        <!-- Task Metric Stats Component -->
        @livewire('task-stats')

        <!-- Queue Section Header -->
        <div class="mt-8 mb-4 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Work Queue</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Add tasks and manage your operational flow.</p>
            </div>
            @livewire('task-filter')
        </div>

        <!-- Two Column Responsive Layout: Create Form & Task List -->
        <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
            <div>
                @livewire('create-task')
            </div>
            <div>
                @livewire('task-list')
            </div>
        </div>
    </div>

    <!-- Edit Task Modal Component -->
    @livewire('edit-task')
@endsection
