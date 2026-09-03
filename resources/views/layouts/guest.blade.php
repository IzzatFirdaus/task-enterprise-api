<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-user-pref="{{ auth()->check() ? (auth()->user()->dark_mode ? 'true' : 'false') : 'null' }}" class="h-full bg-slate-50 dark:bg-slate-900">
    @php
        $pageTitles = [
            'login' => 'Sign In',
            'register' => 'Create Account',
            'password.request' => 'Reset Password',
            'password.reset' => 'Choose New Password',
            'password.confirm' => 'Confirm Password',
            'verification.notice' => 'Verify Email Address',
            'admin.login' => 'Admin Sign In',
        ];
        $routeName = request()->route()?->getName();
        $pageTitle = $pageTitles[$routeName] ?? 'Account Access';
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $pageTitle }} for the Enterprise Tasks workspace.">
        <meta name="robots" content="index,follow">
        <link rel="canonical" href="{{ request()->url() }}">
        <title>{{ $pageTitle }} | {{ config('app.name', 'Enterprise Tasks') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="icon" href="{{ asset('favicon-32x32.svg') }}" type="image/svg+xml" sizes="32x32">
        <link rel="icon" href="{{ asset('favicon-192x192.svg') }}" type="image/svg+xml" sizes="192x192">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.svg') }}" sizes="180x180">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">
        @if (config('app.seo.google_verification'))
            <meta name="google-site-verification" content="{{ config('app.seo.google_verification') }}">
        @endif
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <script>
            (function() {
                const stored = localStorage.getItem('darkMode');
                const userPrefValue = document.documentElement.dataset.userPref;
                const userPref = userPrefValue === 'null' ? null : userPrefValue === 'true';
                let isDark = false;
                if (stored !== null) {
                    isDark = stored === 'true';
                } else if (userPref !== null) {
                    isDark = userPref;
                } else {
                    isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                }
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-full max-w-full flex-col justify-center overflow-x-hidden py-12 sm:px-6 lg:px-8 font-sans text-slate-900 dark:text-slate-100 bg-slate-50 dark:bg-slate-900 antialiased selection:bg-cyan-500 selection:text-white bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] dark:bg-[radial-gradient(#334155_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <a href="/" class="inline-flex items-center gap-2.5 group focus:outline-none focus:ring-2 focus:ring-cyan-500 rounded-xl p-1">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-700 dark:bg-cyan-600 text-white shadow-md transition group-hover:bg-cyan-800 dark:group-hover:bg-cyan-500 group-hover:scale-105">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </a>
            <h2 class="mt-4 text-center text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Enterprise Tasks
            </h2>
            <p class="mt-1 text-center text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400 font-medium">
                Operations &amp; Task Command
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
            <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 sm:p-8 shadow-xl shadow-slate-200/50 dark:shadow-slate-950/50">
                <main id="main-content">{{ $slot }}</main>
            </div>
        </div>
        <x-site-enhancements />
    </body>
</html>
