@extends('layouts.public', ['title' => $post['title'], 'description' => $post['description']])

@section('content')
<article class="mx-auto max-w-3xl px-6 py-16 sm:py-24" itemscope itemtype="https://schema.org/Article">
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 transition duration-150 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-300" aria-label="Back to journal">
        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        Back to journal
    </a>

    <div class="mt-8 flex flex-wrap items-center gap-x-3 gap-y-1">
        <time class="text-xs font-semibold text-slate-500 dark:text-slate-400" datetime="{{ $post['date'] }}" itemprop="datePublished">{{ $post['date'] }}</time>
        <span class="text-xs text-slate-400" aria-hidden="true">&bull;</span>
        <span class="text-xs font-medium text-slate-600 dark:text-slate-400" itemprop="author">Enterprise Tasks</span>
    </div>

    <h1 class="mt-4 text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl" itemprop="headline">{{ $post['title'] }}</h1>
    <p class="mt-6 text-xl leading-8 text-slate-700 dark:text-slate-300" itemprop="description">{{ $post['description'] }}</p>

    <div class="mt-10 max-w-none" itemprop="articleBody">
        <div class="prose max-w-none text-base leading-8 text-slate-700 dark:prose-invert dark:text-slate-300 whitespace-pre-line">{{ $post['body'] }}</div>
    </div>

    <footer class="mt-16 border-t border-slate-200 dark:border-slate-800 pt-8">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 transition duration-150 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-300">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Back to all articles
        </a>
    </footer>
</article>
@endsection
