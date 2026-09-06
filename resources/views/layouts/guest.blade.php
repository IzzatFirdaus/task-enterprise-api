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
        <link href="https://fonts.bunny.net/css?family=public-sans:400,500,600,700&display=swap" rel="stylesheet" />
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
    <body class="guest-shell flex min-h-full max-w-full flex-col justify-center overflow-x-hidden py-12 sm:px-6 lg:px-8 font-sans text-slate-900 dark:text-slate-100 antialiased selection:bg-teal-700 selection:text-white">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <div class="flex items-center justify-center gap-3">
                <a href="{{ route('guest') }}" class="inline-flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-cyan-500 rounded-xl p-1">
                    <span class="flex h-8 w-8 items-center justify-center rounded-md bg-teal-700 text-xs font-bold text-white">ET</span>
                    <span class="flex flex-col text-left"><span class="text-sm font-semibold leading-none text-slate-900 dark:text-white">Enterprise Tasks</span><span class="mt-1 text-[10px] leading-none text-slate-500 dark:text-slate-400">Personal work queue</span></span>
                </a>
                    <button type="button" data-theme-toggle class="inline-flex min-h-11 items-center rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-cyan-500 dark:border-slate-600 dark:text-slate-300" aria-label="Switch between light and dark theme">Theme</button>
            </div>
            <h2 class="mt-4 text-center text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Enterprise Tasks
            </h2>
            <p class="mt-1 text-center text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400 font-medium">
                Task management workspace
            </p>
        </div>

        <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0 space-y-3">
            @if (session('status'))
                <div class="flex items-start gap-3 rounded-xl border border-cyan-200 dark:border-cyan-800/60 bg-cyan-50 dark:bg-cyan-950/40 px-4 py-3 text-sm text-cyan-800 dark:text-cyan-300 shadow-sm" role="status">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-cyan-600 dark:text-cyan-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('status') }}</span>
                </div>
            @endif
            @if (session('success'))
                <div class="flex items-start gap-3 rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 shadow-sm" role="status">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="flex items-start gap-3 rounded-xl border border-rose-200 dark:border-rose-800/60 bg-rose-50 dark:bg-rose-950/40 px-4 py-3 text-sm text-rose-800 dark:text-rose-300 shadow-sm" role="alert">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
            <div class="rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 sm:p-8">
                <main id="main-content">{{ $slot }}</main>
            </div>
        </div>
        <x-site-enhancements />
    </body>
</html>
