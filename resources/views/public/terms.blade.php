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
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Service-level commitment</h2>
            <p class="mt-3 leading-8">We target at least 99% monthly uptime for the personal workspace and administrative surfaces, measured at the HTTP layer excluding planned maintenance and force majeure. Personal task reads and writes are scoped to your account; administrative actions are recorded for review and remain recoverable while the audit log is retained.</p>
            <ul class="mt-4 list-disc space-y-2 pl-6 leading-7">
                <li><strong>Support contact:</strong> {{ config('app.seo.contact_email') }}</li>
                <li><strong>Response window:</strong> best-effort within three business days for general questions; security reports acknowledged within one business day.</li>
                <li><strong>Data retention:</strong> personal task content remains available while your account is active. Administrative audit history is retained to support accountability reviews.</li>
                <li><strong>Backup and recovery:</strong> soft-deleted tasks can be restored by authorized staff; full account data can be exported before deletion from your profile page.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Acceptable use</h2>
            <p class="mt-3 leading-8">The workspace is intended for personal task management. Automated scraping, mass data extraction, or attempts to disrupt the service for other users are not permitted.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Availability and changes</h2>
            <p class="mt-3 leading-8">The application is in active development. Features may change as the product evolves. We may update these terms when the service or its legal requirements change; the effective date above identifies the current version.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Contact</h2>
            <p class="mt-3 leading-8">For questions about these terms, contact <a class="font-semibold text-teal-700 underline decoration-teal-700/40 underline-offset-2 transition duration-150 hover:text-teal-800 dark:text-teal-400 dark:decoration-teal-400/40 dark:hover:text-teal-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-600" href="mailto:{{ config('app.seo.contact_email') }}">{{ config('app.seo.contact_email') }}</a>.</p>
        </section>
    </div>
</article>
@endsection
