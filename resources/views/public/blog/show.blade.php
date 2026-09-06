@extends('layouts.public', ['title' => $post['title'], 'description' => $post['description']])

@section('content')
<article class="mx-auto max-w-3xl px-5 py-20 sm:py-28" itemscope itemtype="https://schema.org/Article">
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-cyan-300 hover:text-cyan-200" aria-label="Back to journal">
        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        Journal
    </a>

    <div class="mt-10 flex flex-wrap items-center gap-x-4 gap-y-1">
        <time class="text-xs font-bold uppercase tracking-widest text-orange-300" datetime="{{ $post['date'] }}" itemprop="datePublished">{{ $post['date'] }}</time>
        <span class="text-xs text-slate-500" aria-hidden="true">|</span>
        <span class="text-xs text-slate-400" itemprop="author">Enterprise Tasks</span>
    </div>

    <h1 class="mt-5 text-4xl font-bold tracking-tight text-white sm:text-6xl" itemprop="headline">{{ $post['title'] }}</h1>
    <p class="mt-6 text-xl leading-9 text-slate-300" itemprop="description">{{ $post['description'] }}</p>

    <div class="mt-12 max-w-none" itemprop="articleBody">
        <div class="prose prose-invert max-w-none text-lg leading-9 text-slate-400 whitespace-pre-line">{{ $post['body'] }}</div>
    </div>

    <footer class="mt-16 border-t border-slate-800 pt-8">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-cyan-300 hover:text-cyan-200">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Back to all articles
        </a>
    </footer>
</article>
@endsection
