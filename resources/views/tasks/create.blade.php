@extends('layouts.app')

@section('title', 'Create Task')
@section('description', 'Create a personal task and define its starting status in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-cyan-700 hover:underline dark:text-cyan-400">&larr; Back to tasks</a>
            <p class="mt-6 text-xs font-semibold uppercase tracking-wider text-cyan-700 dark:text-cyan-400">Personal workload</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Create a task</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Capture the next piece of work while the context is fresh.</p>
        </div>

        @livewire('create-task')
    </div>
@endsection
