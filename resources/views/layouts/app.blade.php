<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Enterprise Tasks') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-10">
                <a href="{{ route('dashboard') }}" class="text-sm font-bold uppercase tracking-[0.18em] text-slate-950">Enterprise Tasks</a>
                @auth
                    <div class="flex items-center gap-4 text-sm">
                        <span class="text-slate-500">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="font-semibold text-slate-700 hover:text-cyan-700">Log out</button>
                        </form>
                    </div>
                @endauth
            </div>
        </header>
        @if (session('success'))
            <div class="mx-auto max-w-7xl px-6 pt-6 lg:px-10"><div class="border-l-4 border-emerald-500 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">{{ session('success') }}</div></div>
        @endif
        <main>@yield('content')</main>
        @livewireScripts
    </body>
</html>
