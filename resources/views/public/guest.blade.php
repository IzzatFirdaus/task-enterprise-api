@extends('layouts.public', ['title' => 'Operational work, made clear', 'description' => 'Enterprise Tasks keeps operational work organized, visible, and moving with a focused personal workspace.'])

@section('content')
    <section class="border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto max-w-6xl px-6 py-20 sm:py-28">
            <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-6xl">Keep the next useful action obvious.</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-700 dark:text-slate-300">Capture personal work, follow progress, and give authorized teams a clear place for accountable administration.</p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('login') }}" class="inline-flex min-h-[44px] items-center rounded-lg bg-teal-700 px-6 py-3 text-sm font-semibold text-white transition duration-150 hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus-visible:ring-offset-slate-950">Sign in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-flex min-h-[44px] items-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-6 py-3 text-sm font-semibold text-slate-900 dark:text-white transition duration-150 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-950">Create an account</a>
                @endif
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-12 px-6 py-16 sm:grid-cols-[minmax(0,1fr)_minmax(0,1.2fr)] sm:items-start sm:py-24">
        <div>
            <h2 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Keep personal work and staff oversight in their proper places.</h2>
            <p class="mt-4 text-base leading-7 text-slate-700 dark:text-slate-300">Clear boundaries protect individual focus while ensuring operational integrity.</p>
        </div>
        <dl class="divide-y divide-slate-200 border-y border-slate-200 dark:divide-slate-800 dark:border-slate-800">
            <div class="grid gap-2 py-6 sm:grid-cols-[9rem_minmax(0,1fr)] sm:gap-6">
                <dt class="font-bold text-slate-950 dark:text-white">Personal workspace</dt>
                <dd class="leading-7 text-slate-700 dark:text-slate-300">Capture the next piece of work, add enough context to begin, and use simple status states to see what is waiting, underway, or complete.</dd>
            </div>
            <div class="grid gap-2 py-6 sm:grid-cols-[9rem_minmax(0,1fr)] sm:gap-6">
                <dt class="font-bold text-slate-950 dark:text-white">Staff surface</dt>
                <dd class="leading-7 text-slate-700 dark:text-slate-300">Keep administrative oversight separate, authorized, and auditable for the people who need it.</dd>
            </div>
        </dl>
    </section>
@endsection