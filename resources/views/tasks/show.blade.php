@extends('layouts.app')

@section('title', $task->title)
@section('description', 'View details for the personal task '.$task->title.'.')

@section('content')
    <article class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                <a href="{{ route('tasks.index') }}" class="inline-flex min-h-[44px] min-w-[44px] items-center px-2 text-base font-semibold text-teal-700 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:text-teal-400 rounded-lg">
                    &larr; Back to tasks
                </a>
                <p class="mt-4 text-sm font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">Task detail</p>
                <h1 class="mt-1 break-words text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">{{ $task->title }}</h1>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('tasks.edit', $task) }}" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl bg-teal-700 px-5 py-3 text-base font-semibold text-white shadow-xs transition hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus-visible:ring-offset-slate-950">
                    Edit task
                </a>
                <a href="{{ route('tasks.create') }}" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-base font-semibold text-slate-800 shadow-xs transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 dark:focus-visible:ring-offset-slate-950">
                    Create task
                </a>
            </div>
        </header>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-xs dark:border-slate-800 dark:bg-slate-900 sm:p-8" aria-labelledby="task-detail-heading">
            <h2 id="task-detail-heading" class="sr-only">Task detail</h2>
            <div class="flex flex-wrap items-center gap-3 border-b border-slate-100 pb-5 dark:border-slate-800">
                <x-badge type="status" :value="$task->status" size="lg" />
                <span class="text-base font-medium text-slate-700 dark:text-slate-300">
                    Created {{ $task->created_at?->format('M d, Y \a\t g:i A') }}
                </span>
                @if ($task->updated_at && $task->updated_at->ne($task->created_at))
                    <span class="text-base font-medium text-slate-700 dark:text-slate-300">
                        &bull; Updated {{ $task->updated_at->diffForHumans() }}
                    </span>
                @endif
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Description</h3>
                @if ($task->description)
                    <p class="mt-3 whitespace-pre-wrap text-base leading-relaxed text-slate-800 dark:text-slate-200">{{ $task->description }}</p>
                @else
                    <p class="mt-3 text-base leading-relaxed text-slate-500 italic dark:text-slate-400">No description provided.</p>
                @endif
            </div>

            <dl class="mt-8 grid gap-5 border-t border-slate-100 pt-6 dark:border-slate-800 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Status</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950 dark:text-slate-100">{{ str_replace('_', ' ', ucfirst($task->status)) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Owner</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950 dark:text-slate-100">{{ $task->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Created</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950 dark:text-slate-100">
                        <time datetime="{{ $task->created_at?->toISOString() }}">{{ $task->created_at?->format('M d, Y') }}</time>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Last updated</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950 dark:text-slate-100">
                        <time datetime="{{ $task->updated_at?->toISOString() }}">{{ $task->updated_at?->format('M d, Y') }}</time>
                    </dd>
                </div>
            </dl>
        </section>
    </article>
@endsection