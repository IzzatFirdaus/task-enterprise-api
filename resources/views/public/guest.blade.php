@extends('layouts.public', ['title' => 'Operational work, made clear', 'description' => 'Enterprise Tasks keeps operational work organized, visible, and moving with a focused personal workspace.'])

@section('content')
    <section class="border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-6xl px-5 py-20 sm:py-28">
            <p class="text-sm font-bold uppercase tracking-[0.2em] text-cyan-700 dark:text-cyan-300">Enterprise Tasks</p>
            <h1 class="mt-5 max-w-3xl text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-6xl">Keep the next useful action obvious.</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300">Capture personal work, follow progress, and give authorized teams a clear place for accountable administration.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('login') }}" class="inline-flex min-h-11 items-center rounded-lg bg-cyan-600 px-5 py-3 font-bold text-white transition hover:bg-cyan-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 dark:focus-visible:ring-cyan-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-50 dark:focus-visible:ring-offset-slate-950 active:bg-cyan-700 dark:active:bg-cyan-400">Sign in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex min-h-11 items-center rounded-lg border border-slate-300 px-5 py-3 font-bold text-slate-900 transition hover:border-cyan-600 hover:text-cyan-800 dark:border-slate-600 dark:text-white dark:hover:border-cyan-400 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 dark:focus-visible:ring-cyan-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-50 dark:focus-visible:ring-offset-slate-950 active:border-cyan-700 active:text-cyan-900 dark:active:border-cyan-300 dark:active:text-cyan-200">Create an account</a>
                @endif
            </div>
        </div>
    </section>
    <section class="mx-auto grid max-w-6xl gap-5 px-5 py-16 sm:grid-cols-3">
        <div><h2 class="text-xl font-bold text-slate-950 dark:text-white">Capture</h2><p class="mt-3 leading-7 text-slate-600 dark:text-slate-400">Turn the next piece of work into a clear task with enough context to begin.</p></div>
        <div><h2 class="text-xl font-bold text-slate-950 dark:text-white">Track</h2><p class="mt-3 leading-7 text-slate-600 dark:text-slate-400">Use simple status states to see what is waiting, underway, or complete.</p></div>
        <div><h2 class="text-xl font-bold text-slate-950 dark:text-white">Govern</h2><p class="mt-3 leading-7 text-slate-600 dark:text-slate-400">Keep administrative oversight separate, authorized, and auditable.</p></div>
    </section>
@endsection