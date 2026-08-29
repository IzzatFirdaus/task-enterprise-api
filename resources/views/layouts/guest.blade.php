<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Enterprise Tasks') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans text-slate-900 antialiased selection:bg-cyan-500 selection:text-white bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <a href="/" class="inline-flex items-center gap-2.5 group focus:outline-none focus:ring-2 focus:ring-cyan-500 rounded-xl p-1">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-700 text-white shadow-md transition group-hover:bg-cyan-800 group-hover:scale-105">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </a>
            <h2 class="mt-4 text-center text-2xl font-bold tracking-tight text-slate-900">
                Enterprise Tasks
            </h2>
            <p class="mt-1 text-center text-xs uppercase tracking-widest text-slate-500 font-medium">
                Operations &amp; Task Command
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
            <div class="rounded-2xl border border-slate-200/90 bg-white p-6 sm:p-8 shadow-xl shadow-slate-200/50">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
