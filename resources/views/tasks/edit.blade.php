@extends('layouts.app')

@section('title', 'Edit Task')
@section('description', 'Update a personal task in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8">
            <a href="{{ route('tasks.index') }}" class="inline-flex min-h-[44px] min-w-[44px] items-center px-2 text-base font-semibold text-teal-700 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:text-teal-400 rounded-lg">
                &larr; Back to tasks
            </a>
            <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">Personal work queue</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Edit task</h1>
            <p class="mt-2 text-base leading-relaxed text-slate-700 dark:text-slate-300">Change the task details or record its current status.</p>
        </header>

        @livewire('edit-task', ['taskId' => $task->id])
    </div>
@endsection
