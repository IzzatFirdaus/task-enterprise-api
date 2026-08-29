<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Enterprise Tasks') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-10">
                <a href="{{ route('dashboard') }}" class="text-sm font-bold uppercase tracking-[0.18em] text-slate-950">Enterprise Tasks</a>
                @auth
                    <span class="text-sm text-slate-500">{{ auth()->user()->name }}</span>
                @endauth
            </div>
        </header>
        <main>{{ $slot }}</main>
        @livewireScripts
    </body>
</html>