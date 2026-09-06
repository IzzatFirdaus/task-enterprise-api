@extends('layouts.public', ['title' => 'Frequently Asked Questions', 'description' => 'Common questions about Enterprise Tasks, covering account access, task management, API usage, administrative governance, and data handling.'])

@section('content')
<section class="border-b border-slate-200 bg-slate-100 dark:border-slate-800 dark:bg-slate-900">
    <div class="mx-auto max-w-6xl px-5 py-20 sm:py-28">
        <p class="text-sm font-bold uppercase tracking-[0.2em] text-cyan-700 dark:text-cyan-300">Help centre</p>
        <h1 class="mt-5 max-w-3xl text-4xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-6xl">Frequently asked questions</h1>
        <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300">Quick answers to common questions about using Enterprise Tasks, managing your workspace, and understanding the administrative surface.</p>
    </div>
</section>

<section class="mx-auto max-w-3xl gap-12 px-5 py-16 sm:py-24">
    <div class="divide-y divide-slate-200 dark:divide-slate-800 rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900 shadow-sm">
        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: How do I create a task?">
                <span class="text-base font-semibold">How do I create a task?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <p>Once signed in, navigate to <a href="{{ route('tasks.index') }}" class="font-medium text-cyan-700 dark:text-cyan-300 hover:underline">your task list</a> and use the create form. Enter a clear title, an optional description, and set the initial status to <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs dark:bg-slate-800">pending</code>. Your task is immediately scoped to your account and visible only to you.</p>
            </div>
        </details>

        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: How does the API work?">
                <span class="text-base font-semibold">How does the API work?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <p>Authenticate with a Sanctum token using the <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs dark:bg-slate-800">Authorization: Bearer &lt;token&gt;</code> header. All task endpoints are scoped to the authenticated user — you can only read and modify your own tasks. See the <a href="{{ route('capabilities.show', 'secure-apis') }}" class="font-medium text-cyan-700 dark:text-cyan-300 hover:underline">secure APIs capability</a> for endpoint details.</p>
            </div>
        </details>

        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: How do I get an API token?">
                <span class="text-base font-semibold">How do I get an API token?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <p>Navigate to your <a href="{{ route('profile.edit') }}" class="font-medium text-cyan-700 dark:text-cyan-300 hover:underline">profile settings</a> and use the API tokens section to create a personal access token. Give it a descriptive name and copy the token immediately — it will not be shown again.</p>
            </div>
        </details>

        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: How do I access the admin panel?">
                <span class="text-base font-semibold">How do I access the admin panel?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <p>The admin panel is separate from the personal workspace. If you have an admin, moderator, or super_admin role, sign in at <a href="{{ route('admin.login') }}" class="font-medium text-cyan-700 dark:text-cyan-300 hover:underline">/admin/login</a> using your admin credentials. Regular user accounts cannot access the admin surface.</p>
            </div>
        </details>

        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: What are the admin roles?">
                <span class="text-base font-semibold">What are the admin roles?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <ul class="list-inside list-disc space-y-1">
                    <li><strong>super_admin</strong> — full system access, user management, settings, and audit logs</li>
                    <li><strong>admin</strong> — operational access for users and task moderation</li>
                    <li><strong>moderator</strong> — task oversight without user-management privileges</li>
                    <li><strong>user</strong> — standard personal task management only</li>
                </ul>
            </div>
        </details>

        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: How do I reset my password?">
                <span class="text-base font-semibold">How do I reset my password?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <p>Visit the <a href="{{ route('login') }}" class="font-medium text-cyan-700 dark:text-cyan-300 hover:underline">sign in page</a> and click <strong>Forgot your password?</strong>. Enter your email address and follow the reset link sent to your inbox.</p>
            </div>
        </details>

        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: What data do you collect?">
                <span class="text-base font-semibold">What data do you collect?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <p>Enterprise Tasks stores only what is needed to operate your personal task workspace and administrative functions: your name, email, password hash, role assignment, task content, and administrative audit logs. No advertising cookies are used. See the <a href="{{ route('terms') }}" class="font-medium text-cyan-700 dark:text-cyan-300 hover:underline">terms of service</a> for full details.</p>
            </div>
        </details>

        <details class="group faq-item" style="scroll-margin-top:5rem">
            <summary class="flex cursor-pointer items-center justify-between gap-4 p-6 text-left font-semibold text-slate-900 dark:text-white hover:text-cyan-700 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500 focus-visible:ring-inset" aria-label="Toggle answer for: How do I contact support?">
                <span class="text-base font-semibold">How do I contact support?</span>
                <svg class="h-5 w-5 shrink-0 text-slate-400 group-open:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </summary>
            <div class="px-6 pb-6 pt-0 text-slate-600 dark:text-slate-300">
                <p>Use the <a href="mailto:{{ config('app.seo.contact_email') }}" class="font-medium text-cyan-700 dark:text-cyan-300 hover:underline">{{ config('app.seo.contact_email') }}</a> address or the floating contact button in the lower-right corner of any page.</p>
            </div>
        </details>
    </div>

    <div class="mt-12 text-center">
        <p class="text-slate-600 dark:text-slate-300">Still have questions? <a href="mailto:{{ config('app.seo.contact_email') }}" class="font-semibold text-cyan-700 dark:text-cyan-300 hover:underline">{{ config('app.seo.contact_email') }}</a></p>
    </div>
</section>
@endsection
