@extends('layouts.public', ['title' => 'Privacy Policy', 'description' => 'How Enterprise Tasks collects, uses, and protects your personal information.'])

@section('content')
<article class="mx-auto max-w-3xl px-6 py-16 sm:py-24 text-slate-700 dark:text-slate-300">
    <h1 class="text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-5xl">Privacy Policy</h1>
    <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Effective {{ now()->format('F j, Y') }}</p>

    <div class="mt-12 space-y-10">
        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Information we collect</h2>
            <p class="mt-3 leading-8">Enterprise Tasks collects the information you provide directly: your name, email address, and the content you add to your task workspace. Administrative users may have access to audit logs that record administrative actions, including operator identity, timestamps, and affected records.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">How we use your information</h2>
            <p class="mt-3 leading-8">Your information is used solely to operate your personal task workspace and to provide authorised administrative functions. We do not sell your data, use it for advertising, or share it with third parties beyond what is required to deliver the service.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Cookies and storage</h2>
            <p class="mt-3 leading-8">The application uses essential session cookies to maintain authentication and store preference settings such as your chosen interface theme. No advertising or tracking cookies are used. Your cookie choices are stored in browser local storage and can be cleared at any time.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Data retention</h2>
            <p class="mt-3 leading-8">Task content, administrative audit logs, and account records are retained for as long as your account is active. Upon account deletion, all personal data is permanently removed unless retention is required for legal compliance.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Your rights</h2>
            <p class="mt-3 leading-8">You have the right to access, correct, or delete your personal data at any time through your account settings or by contacting the administrator. You may also request an export of your data before closing your account.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Contact</h2>
            <p class="mt-3 leading-8">For privacy-related questions or to exercise your rights, contact <a href="mailto:{{ config('app.seo.contact_email') }}" class="font-semibold text-teal-700 underline decoration-teal-700/40 underline-offset-2 transition duration-150 hover:text-teal-800 dark:text-teal-400 dark:decoration-teal-400/40 dark:hover:text-teal-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">{{ config('app.seo.contact_email') }}</a>.</p>
        </section>

        <section>
            <h2 class="text-xl font-bold text-slate-950 dark:text-white">Changes to this policy</h2>
            <p class="mt-3 leading-8">We may update this policy from time to time. The effective date at the top of this page reflects the last revision. Continued use of the service after changes constitutes acceptance of the updated policy.</p>
        </section>
    </div>
</article>
@endsection
