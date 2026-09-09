@extends('layouts.public', ['title' => 'Cookie Policy', 'description' => 'How Enterprise Tasks uses cookies and storage technologies.'])
@section('content')
<article class="mx-auto max-w-3xl px-6 py-16 text-slate-700 sm:py-24 dark:text-slate-300">
    <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">Cookie Policy</h1>
    <p class="mt-3 text-base leading-relaxed text-slate-500 dark:text-slate-400">Effective {{ now()->format('F j, Y') }}</p>
    <div class="mt-12 space-y-10">
        <section><h2 class="text-2xl font-bold text-slate-900 dark:text-white">What are cookies</h2><p class="mt-3 text-base leading-relaxed">Cookies are small text files stored on your device to help us maintain sessions, store your theme preference, and keep authentication stable.</p></section>
        <section><h2 class="text-2xl font-bold text-slate-900 dark:text-white">Essential cookies</h2><p class="mt-3 text-base leading-relaxed">These are required for the service to function, including session authentication and preference storage. They do not track browsing across other sites.</p></section>
        <section><h2 class="text-2xl font-bold text-slate-900 dark:text-white">Analytical cookies</h2><p class="mt-3 text-base leading-relaxed">We do not currently use analytical cookies. If introduced, they would help us understand feature usage without identifying individuals and would only load after you explicitly accept.</p></section>
        <section><h2 class="text-2xl font-bold text-slate-900 dark:text-white">Marketing and third-party cookies</h2><p class="mt-3 text-base leading-relaxed">None are used. We do not embed advertising pixels or social widgets that set tracking cookies.</p></section>
        <section>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Your choices</h2>
            <p class="mt-3 text-base leading-relaxed">You may accept or decline non-essential choices via the banner at the bottom of the screen. Both options carry equal visual weight; declining leaves only essential session cookies active. Your choice is stored in browser local storage and can be cleared at any time.</p>
        </section>
    </div>
</article>
@endsection
