@extends('layouts.public', ['title' => 'Journal', 'description' => 'Practical notes on personal task management, operational clarity, and accountable administration.'])

@section('content')
<section class="mx-auto max-w-6xl px-6 py-16 sm:py-24">
    <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">Notes for work that moves.</h1>
    <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-700 dark:text-slate-300">Practical notes on task management, administrative integrity, and operational focus.</p>

    <div class="mt-12 grid gap-6 md:grid-cols-2">
        @foreach ($posts as $post)
            <article class="flex flex-col justify-between rounded-xl border border-slate-200 bg-white p-6 shadow-xs transition duration-150 hover:border-teal-600 dark:border-slate-800 dark:bg-slate-900 dark:hover:border-teal-500">
                <div>
                    <time class="text-xs font-semibold text-slate-500 dark:text-slate-400" datetime="{{ $post['date'] }}">{{ $post['date'] }}</time>
                    <h2 class="mt-3 text-2xl font-bold text-slate-950 dark:text-white">
                        <a href="{{ route('blog.show', $post['slug']) }}" class="transition duration-150 hover:text-teal-700 dark:hover:text-teal-300">
                            {{ $post['title'] }}
                        </a>
                    </h2>
                    <p class="mt-3 text-sm leading-6 text-slate-700 dark:text-slate-300">{{ $post['description'] }}</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('blog.show', $post['slug']) }}" class="text-sm font-semibold text-teal-700 transition duration-150 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-300">
                        Read article
                    </a>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endsection