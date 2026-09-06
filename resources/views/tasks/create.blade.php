@extends('layouts.app')

@section('title', 'Create Task')
@section('description', 'Create a personal task and define its starting status in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-cyan-700 hover:underline dark:text-cyan-400">&larr; Back to tasks</a>
            <p class="mt-6 text-xs font-semibold uppercase tracking-[0.14em] text-teal-700 dark:text-teal-300">Personal work queue</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Create a task</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Add a task with the context needed to start it.</p>
        </div>

        @livewire('create-task')
    </div>
@endsection
