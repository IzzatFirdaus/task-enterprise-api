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
        <meta name="robots" content="noindex,nofollow">
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
                (() => {
                    const stored = localStorage.getItem('theme');
                    const isDark = stored === 'dark'
                        || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

                    document.documentElement.classList.toggle('dark', isDark);
                })();
            </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-full max-w-full flex-col justify-center overflow-x-hidden py-12 sm:px-6 lg:px-8 font-sans text-slate-900 dark:text-slate-100 bg-slate-50 dark:bg-slate-900 antialiased selection:bg-cyan-500 selection:text-white bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] dark:bg-[radial-gradient(#334155_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('guest') }}" class="inline-flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-500 rounded-xl p-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-500 text-xs font-bold text-white">ET</span>
                    <span class="flex flex-col text-left"><span class="text-sm font-semibold leading-none text-slate-900 dark:text-white">Enterprise Tasks</span><span class="mt-1 text-[10px] leading-none text-slate-500 dark:text-slate-400">Operational clarity</span></span>
                </a>
                    <button type="button" data-theme-toggle class="min-h-11 rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-cyan-500 dark:border-slate-600 dark:text-slate-300" aria-label="Switch theme">Theme</button>
            </div>
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
