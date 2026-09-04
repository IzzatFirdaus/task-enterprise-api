@extends('layouts.app')

@section('title', 'Edit Task')
@section('description', 'Update a personal task and keep its delivery status current in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-cyan-700 hover:underline dark:text-cyan-400">&larr; Back to tasks</a>
            <p class="mt-6 text-xs font-semibold uppercase tracking-wider text-cyan-700 dark:text-cyan-400">Personal workload</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Edit task</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update the task details or move it to its next status.</p>
        </div>

        @livewire('edit-task', ['taskId' => $task->id])
    </div>
@endsection
