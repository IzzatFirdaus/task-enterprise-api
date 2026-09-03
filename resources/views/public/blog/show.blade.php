@extends('layouts.public', ['title' => $post['title'], 'description' => $post['description']])

@section('content')
<article class="mx-auto max-w-3xl px-5 py-20 sm:py-28"><a href="{{ route('blog.index') }}" class="text-sm font-bold text-cyan-300 hover:text-cyan-200">&lt;- Back to journal</a><time class="mt-12 block text-xs font-bold uppercase tracking-widest text-orange-300" datetime="{{ $post['date'] }}">{{ $post['date'] }}</time><h1 class="mt-4 text-4xl font-bold tracking-tight text-white sm:text-6xl">{{ $post['title'] }}</h1><p class="mt-6 text-xl leading-9 text-slate-300">{{ $post['description'] }}</p><div class="prose prose-invert mt-12 max-w-none whitespace-pre-line text-lg leading-9 text-slate-400">{{ $post['body'] }}</div></article>
@endsection