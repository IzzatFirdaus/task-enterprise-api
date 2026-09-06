@extends('layouts.app')

@section('title', $task->title)
@section('description', 'View details for the personal task '.$task->title.'.')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                <a href="{{ route('tasks.index') }}" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-teal-700 hover:underline dark:text-teal-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 rounded-lg pr-2">
                    &larr; Back to tasks
                </a>
                <p class="mt-4 text-xs font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">Task detail</p>
                <h1 class="mt-1 break-words text-2xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-3xl">{{ $task->title }}</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('tasks.edit', $task) }}" class="inline-flex min-h-[44px] items-center justify-center rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus-visible:ring-offset-slate-950">
                    Edit task
                </a>
                <a href="{{ route('tasks.create') }}" class="inline-flex min-h-[44px] items-center justify-center rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-800 dark:text-slate-200 shadow-xs transition hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-950">
                    Create task
                </a>
            </div>
        </header>

        <article class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs dark:border-slate-800 dark:bg-slate-900 sm:p-8">
            <div class="flex flex-wrap items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
                <x-badge type="status" :value="$task->status" size="lg" />
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                    Created {{ $task->created_at?->format('M d, Y \a\t g:i A') }}
                </span>
                @if ($task->updated_at && $task->updated_at->ne($task->created_at))
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">
                        &bull; Updated {{ $task->updated_at->diffForHumans() }}
                    </span>
                @endif
            </div>

            <div class="mt-6">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Description</h2>
                @if ($task->description)
                    <p class="mt-3 whitespace-pre-wrap text-base leading-7 text-slate-800 dark:text-slate-200">{{ $task->description }}</p>
                @else
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400 italic">No description provided.</p>
                @endif
            </div>

            <dl class="mt-8 grid gap-5 border-t border-slate-100 pt-6 dark:border-slate-800 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Status</dt>
                    <dd class="mt-1 text-sm font-semibold text-slate-950 dark:text-slate-100">{{ str_replace('_', ' ', ucfirst($task->status)) }}</dd>
                </div>
                @if (array_key_exists('priority', $task->getAttributes()))
                    <div>
                        <dt class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Priority</dt>
                        <dd class="mt-1 text-sm font-semibold text-slate-950 dark:text-slate-100">{{ $task->priority ?: 'Not set' }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Owner</dt>
                    <dd class="mt-1 text-sm font-semibold text-slate-950 dark:text-slate-100">{{ $task->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Created</dt>
                    <dd class="mt-1 text-sm font-semibold text-slate-950 dark:text-slate-100">
                        <time datetime="{{ $task->created_at?->toISOString() }}">{{ $task->created_at?->format('M d, Y') }}</time>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Last updated</dt>
                    <dd class="mt-1 text-sm font-semibold text-slate-950 dark:text-slate-100">
                        <time datetime="{{ $task->updated_at?->toISOString() }}">{{ $task->updated_at?->format('M d, Y') }}</time>
                    </dd>
                </div>
            </dl>
        </article>
    </div>
@endsection