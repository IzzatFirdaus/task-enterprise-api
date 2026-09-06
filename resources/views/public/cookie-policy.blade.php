@extends('layouts.public', ['title' => 'Cookie Policy', 'description' => 'How Enterprise Tasks uses cookies and storage technologies.'])
@section('content')
<article class="mx-auto max-w-3xl px-5 py-16 text-slate-600 sm:py-24 dark:text-slate-400">
    <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white">Cookie Policy</h1>
    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Effective {{ now()->format('F j, Y') }}</p>
    <div class="mt-12 space-y-10">
        <section><h2 class="text-xl font-bold text-slate-900 dark:text-white">What are cookies</h2><p class="mt-3 leading-8">Cookies are small text files stored on your device to help us maintain sessions, store your theme preference, and keep authentication stable.</p></section>
        <section><h2 class="text-xl font-bold text-slate-900 dark:text-white">Essential cookies</h2><p class="mt-3 leading-8">These are required for the service to function, including session authentication and preference storage. They do not track browsing across other sites.</p></section>
        <section><h2 class="text-xl font-bold text-slate-900 dark:text-white">Analytical cookies</h2><p class="mt-3 leading-8">We do not currently use analytical cookies. If introduced, they would help us understand feature usage without identifying individuals.</p></section>
        <section><h2 class="text-xl font-bold text-slate-900 dark:text-white">Marketing and third-party cookies</h2><p class="mt-3 leading-8">None are used. We do not embed advertising pixels or social widgets that set tracking cookies.</p></section>
        <section><h2 class="text-xl font-bold text-slate-900 dark:text-white">Your choices</h2><p class="mt-3 leading-8">You may accept or decline non-essential choices via the banner at the bottom of the screen. Essential session cookies remain necessary for security.</p></section>
    </div>
</article>
@endsection
