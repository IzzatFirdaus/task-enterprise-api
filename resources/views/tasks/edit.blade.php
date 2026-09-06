@extends('layouts.app')

@section('title', 'Edit Task')
@section('description', 'Update a personal task in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-cyan-700 hover:underline dark:text-cyan-400">&larr; Back to tasks</a>
            <p class="mt-6 text-xs font-semibold uppercase tracking-[0.14em] text-teal-700 dark:text-teal-300">Personal work queue</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Edit task</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Change the task details or record its current status.</p>
        </div>

        @livewire('edit-task', ['taskId' => $task->id])
    </div>
@endsection
