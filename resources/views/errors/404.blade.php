<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="The requested Enterprise Tasks page could not be found.">
        <title>Page Not Found | {{ config('app.name', 'Enterprise Tasks') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen max-w-full items-center justify-center overflow-x-hidden bg-slate-100 px-4 font-sans text-slate-900 dark:bg-slate-900 dark:text-slate-100">
        <main class="w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-8 text-center shadow-xl dark:border-slate-800 dark:bg-slate-800 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-widest text-cyan-700 dark:text-cyan-400">Error 404</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight">Page not found</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-400">That destination is unavailable or may have moved. Return to the workspace to continue managing your tasks.</p>
            <a href="{{ url('/') }}" class="mt-7 inline-flex min-h-11 items-center justify-center rounded-lg bg-cyan-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:bg-cyan-600 dark:hover:bg-cyan-500">Return to Enterprise Tasks</a>
        </main>
    </body>
</html>
