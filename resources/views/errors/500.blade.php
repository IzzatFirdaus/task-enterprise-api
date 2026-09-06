<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 dark:bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <x-seo-head
            title="Something went wrong"
            description="The Enterprise Tasks application hit an unexpected error."
            robots="noindex,nofollow"
        />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=public-sans:400,500,600,700&display=swap" rel="stylesheet" />
        <script>
            (() => {
                const stored = localStorage.getItem('theme');
                const isDark = stored === null
                    ? window.matchMedia('(prefers-color-scheme: dark)').matches
                    : stored === 'dark';

                document.documentElement.classList.toggle('dark', isDark);
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen max-w-full items-center justify-center overflow-x-hidden bg-slate-50 px-4 py-12 font-sans text-slate-900 dark:bg-slate-950 dark:text-slate-100 sm:py-20">
        <main class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-widest text-rose-700 dark:text-rose-400">Error 500</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Something went wrong</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">The application hit an unexpected error. Please retry in a moment, and reach out to support if the issue continues.</p>
            <div class="mt-7 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ url('/') }}" class="inline-flex min-h-11 items-center justify-center rounded-lg bg-cyan-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:bg-cyan-600 dark:hover:bg-cyan-500">Go to home</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex min-h-11 items-center justify-center rounded-lg border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-cyan-500 hover:text-cyan-700 dark:border-slate-700 dark:text-slate-200 dark:hover:border-cyan-400 dark:hover:text-cyan-300">Open dashboard</a>
                @endauth
            </div>
        </main>
    </body>
</html>
