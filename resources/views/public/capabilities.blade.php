@extends('layouts.public', ['title' => 'Capabilities', 'description' => 'Explore task capture, progress tracking, secure APIs, and administrative governance in Enterprise Tasks.'])

@section('content')
<section class="mx-auto max-w-6xl px-6 py-16 sm:py-24">
    <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">A focused workspace with responsible edges.</h1>
    <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-700 dark:text-slate-300">Understand the foundational components that keep personal tasks actionable and administrative surfaces accountable.</p>
    
    <div class="mt-12 grid gap-6 sm:grid-cols-2">
        @foreach ($capabilities as $slug => $capability)
            <a href="{{ route('capabilities.show', $slug) }}" class="group flex flex-col justify-between rounded-xl border border-slate-200 bg-white p-6 shadow-xs transition duration-150 hover:border-teal-600 dark:border-slate-800 dark:bg-slate-900 dark:hover:border-teal-500">
                <div>
                    <span class="text-xs font-semibold text-teal-700 dark:text-teal-400 font-mono">0{{ $loop->iteration }}</span>
                    <h2 class="mt-4 text-xl font-bold text-slate-950 transition duration-150 group-hover:text-teal-700 dark:text-white dark:group-hover:text-teal-300">{{ $capability['title'] }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-700 dark:text-slate-300">{{ $capability['summary'] }}</p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800 text-sm font-semibold text-slate-900 dark:text-white group-hover:text-teal-700 dark:group-hover:text-teal-300">
                    Explore capability
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection