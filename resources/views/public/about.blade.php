@extends('layouts.public', ['title' => 'About', 'description' => 'Learn why Enterprise Tasks exists and how it keeps personal work and administrative governance clear.'])

@section('content')
<section class="border-b border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-950">
    <div class="mx-auto max-w-6xl px-6 py-20 sm:py-28">
        <h1 class="max-w-3xl text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-6xl">Make the next useful action obvious.</h1>
        <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-700 dark:text-slate-300">Enterprise Tasks began with a simple observation: personal work gets harder to finish when the system around it is noisy. The product keeps capture, progress, and governance in their proper places.</p>
    </div>
</section>

<section class="mx-auto max-w-6xl px-6 py-16 sm:py-24">
    <div class="grid gap-12 sm:gap-16 lg:grid-cols-[1.1fr_1fr] items-start">
        <!-- Lead Mission Block -->
        <div class="rounded-xl border border-slate-200 bg-white p-8 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="text-2xl font-bold text-slate-950 dark:text-white">Our Purpose</h2>
            <p class="mt-4 text-base leading-8 text-slate-700 dark:text-slate-300">We give people a calm, private workspace to move work forward without organizational distraction or cluttered dashboard widgets.</p>
            <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-400">Software should reduce cognitive load, not compete for attention with notifications and unearned urgency.</p>
        </div>

        <!-- Structured Principles & Team Column -->
        <div class="space-y-8">
            <div class="border-b border-slate-200 pb-8 dark:border-slate-800">
                <h3 class="text-xl font-bold text-slate-950 dark:text-white">Core Principles</h3>
                <p class="mt-3 text-base leading-7 text-slate-700 dark:text-slate-300">Strict ownership, understandable states, and accountable administration guide every architectural decision.</p>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-950 dark:text-white">Team Discipline</h3>
                <p class="mt-3 text-base leading-7 text-slate-700 dark:text-slate-300">A focused, product-minded team prioritizing dependable daily workflows, keyboard navigation, and accessibility over feature bloat.</p>
            </div>
        </div>
    </div>
</section>

<section class="border-y border-slate-200 bg-slate-50 dark:border-slate-800 dark:bg-slate-900">
    <div class="mx-auto flex max-w-6xl flex-col gap-6 px-6 py-16 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-950 dark:text-white">See how the workspace works</h2>
            <p class="mt-2 text-slate-700 dark:text-slate-300">Explore the product capabilities or start with your account.</p>
        </div>
        <a href="{{ route('capabilities') }}" class="inline-flex min-h-[44px] items-center rounded-lg bg-teal-700 px-6 py-3 text-sm font-semibold text-white transition duration-150 hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500 dark:focus-visible:ring-offset-slate-950">Explore capabilities</a>
    </div>
</section>
@endsection