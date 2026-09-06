@extends('layouts.public', ['title' => $capability['title'], 'description' => $capability['summary']])

@section('content')
<section class="mx-auto max-w-4xl px-6 py-16 sm:py-24">
    <a href="{{ route('capabilities') }}" class="inline-flex items-center text-sm font-semibold text-teal-700 transition duration-150 hover:text-teal-800 dark:text-teal-400 dark:hover:text-teal-300">
        &larr; Back to all capabilities
    </a>

    <h1 class="mt-8 text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">{{ $capability['title'] }}</h1>
    <p class="mt-6 text-xl leading-8 text-slate-700 dark:text-slate-300">{{ $capability['summary'] }}</p>

    <div class="mt-10 rounded-xl border border-slate-200 bg-white p-6 sm:p-8 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-base leading-8 text-slate-700 dark:text-slate-300">{{ $capability['details'] }}</p>
    </div>

    <div class="mt-10">
        <a href="{{ route('register') }}" class="inline-flex min-h-[44px] items-center rounded-lg bg-teal-700 px-6 py-3 text-sm font-semibold text-white transition duration-150 hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus-visible:ring-offset-slate-950">Create your workspace</a>
    </div>
</section>
@endsection