<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 dark:bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <x-seo-head
            title="Page not found"
            description="The requested Enterprise Tasks page could not be found."
            robots="noindex,nofollow"
        />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=public-sans:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen max-w-full items-center justify-center overflow-x-hidden bg-slate-50 px-4 py-12 font-sans text-slate-900 dark:bg-slate-950 dark:text-slate-100 sm:py-20">
        <main class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-xl dark:border-slate-800 dark:bg-slate-900 sm:p-10">
            <p class="text-xs font-bold uppercase tracking-wider text-teal-700 dark:text-teal-400">Error 404</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Page not found</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">The page you are looking for could not be found or may have moved.</p>
            <div class="mt-7 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ url('/') }}" class="inline-flex min-h-[44px] items-center justify-center rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white shadow-xs transition hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:bg-teal-600 dark:hover:bg-teal-500">
                    Return to home
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex min-h-[44px] items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50 hover:border-slate-400 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">
                        Open dashboard
                    </a>
                @endauth
            </div>
        </main>
    </body>
</html>
