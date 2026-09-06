@extends('layouts.public', ['title' => 'Terms of Service', 'description' => 'The terms that govern use of the Enterprise Tasks application.'])

@section('content')
<article class="mx-auto max-w-3xl px-6 py-16 sm:py-24 text-slate-700 dark:text-slate-300">
    <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">Terms of Service</h1>
    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Effective {{ now()->format('F j, Y') }}</p>

    <div class="mt-12 space-y-10">
        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Use of the service</h2>
            <p class="mt-3 leading-8">Enterprise Tasks provides a workspace for capturing and progressing personal tasks. You are responsible for the accuracy of content added to your account and for protecting your credentials.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Account boundaries</h2>
            <p class="mt-3 leading-8">Do not attempt to access another account or bypass role-based administrative controls. Staff tools are provided only to authorized operators and actions may be recorded for security review.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Availability and support</h2>
            <p class="mt-3 leading-8">The application is in active development. Features may change as the product evolves. For questions about these terms, contact <a class="font-semibold text-teal-700 underline decoration-teal-700/40 underline-offset-2 transition duration-150 hover:text-teal-800 dark:text-teal-400 dark:decoration-teal-400/40 dark:hover:text-teal-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-600" href="mailto:{{ config('app.seo.contact_email') }}">{{ config('app.seo.contact_email') }}</a>.</p>
        </section>
        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Changes</h2>
            <p class="mt-3 leading-8">We may update these terms when the service or its legal requirements change. The effective date above identifies the current version.</p>
        </section>
    </div>
</article>
@endsection