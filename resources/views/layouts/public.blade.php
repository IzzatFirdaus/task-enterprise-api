<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 dark:bg-slate-950">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <x-seo-head :title="$title ?? 'Operational work, made clear'" :description="$description ?? 'A focused task workspace for personal execution and accountable administration.'" />
        @php
            $structuredData = [
                '@context' => 'https://schema.org',
                '@graph' => [
                    [
                        '@type' => 'SoftwareApplication',
                        'name' => config('app.name', 'Enterprise Tasks'),
                        'applicationCategory' => 'BusinessApplication',
                        'operatingSystem' => 'Web',
                        'description' => $description ?? 'A focused task workspace for personal execution and accountable administration.',
                        'url' => url('/'),
                        'provider' => ['@id' => url('/').'#organization'],
                    ],
                    [
                        '@type' => 'Organization',
                        '@id' => url('/').'#organization',
                        'name' => config('app.name', 'Enterprise Tasks'),
                        'url' => url('/'),
                        'email' => config('app.seo.contact_email'),
                    ],
                ],
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES) !!}</script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
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
    <body class="min-h-full overflow-x-hidden bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <a href="#main-content" class="skip-link focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400 focus-visible:ring-offset-2">Skip to main content</a>
        <header class="border-b border-slate-200 bg-white/95 dark:border-slate-800 dark:bg-slate-950/95">
            <nav class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-5" aria-label="Public navigation">
                <a href="{{ route('guest') }}" class="flex items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400" aria-label="Enterprise Tasks home">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-cyan-500 text-xs font-bold text-white">ET</span>
                    <span><strong class="block text-sm font-semibold leading-none text-slate-950 dark:text-white">Enterprise Tasks</strong><span class="mt-1 block text-[10px] leading-none text-slate-500 dark:text-slate-400">Operational clarity</span></span>
                </a>
                <div class="hidden items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-300 sm:flex">
                    <a href="{{ route('capabilities') }}" class="rounded-lg px-3 py-1.5 transition {{ request()->routeIs('capabilities*') ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white' : 'hover:text-cyan-700 dark:hover:text-cyan-300' }}">Capabilities</a>
                    <a href="{{ route('faq') }}" class="rounded-lg px-3 py-1.5 transition {{ request()->routeIs('faq') ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white' : 'hover:text-cyan-700 dark:hover:text-cyan-300' }}">FAQ</a>
                    <a href="{{ route('blog.index') }}" class="rounded-lg px-3 py-1.5 transition {{ request()->routeIs('blog.*') ? 'bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white' : 'hover:text-cyan-700 dark:hover:text-cyan-300' }}">Journal</a>
                    <button type="button" data-theme-toggle class="rounded-full border border-slate-200 px-3 py-1 text-xs hover:border-cyan-500 hover:text-slate-950 dark:border-slate-700 dark:hover:text-white" aria-label="Switch theme">Theme</button>
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-cyan-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-cyan-500">Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium transition hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-white" aria-label="Open profile for {{ auth()->user()->name }}">
                            <span class="grid h-7 w-7 place-items-center rounded-full bg-slate-200 text-[11px] font-bold text-slate-700 dark:bg-slate-700 dark:text-slate-200">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg border border-slate-700 px-3 py-2 hover:border-cyan-500 hover:text-white">Sign in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-lg bg-cyan-500 px-3 py-2 text-slate-950 hover:bg-cyan-300">Register</a>
                        @endif
                    @endauth
                </div>
                <details class="relative sm:hidden">
                    <summary class="flex min-h-11 cursor-pointer list-none items-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400 dark:border-slate-700 dark:text-slate-200" aria-label="Open navigation menu">
                        <span aria-hidden="true">Menu</span>
                    </summary>
                    <div class="absolute right-0 top-14 z-50 w-48 rounded-lg border border-slate-200 bg-white p-2 text-sm font-semibold text-slate-700 shadow-xl dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                        <a href="{{ route('capabilities') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-100 hover:text-cyan-700 dark:hover:bg-slate-800 dark:hover:text-cyan-300">Capabilities</a>
                        <a href="{{ route('faq') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-100 hover:text-cyan-700 dark:hover:bg-slate-800 dark:hover:text-cyan-300">FAQ</a>
                        <a href="{{ route('blog.index') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-100 hover:text-cyan-700 dark:hover:bg-slate-800 dark:hover:text-cyan-300">Journal</a>
                        <button type="button" data-theme-toggle class="block w-full rounded-md px-3 py-2.5 text-left hover:bg-slate-100 hover:text-cyan-700 dark:hover:bg-slate-800 dark:hover:text-cyan-300" aria-label="Switch theme">Theme</button>
                        @auth
                            <a href="{{ route('dashboard') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-md px-3 py-2.5 hover:bg-slate-100 hover:text-cyan-700 dark:hover:bg-slate-800 dark:hover:text-cyan-300" aria-label="Open profile for {{ auth()->user()->name }}"><span class="grid h-7 w-7 place-items-center rounded-full bg-slate-200 text-[11px] font-bold text-slate-700 dark:bg-slate-700 dark:text-slate-200">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span><span>{{ auth()->user()->name }}</span></a>
                        @else
                            <a href="{{ route('login') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Sign in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Register</a>
                            @endif
                        @endauth
                    </div>
                </details>
            </nav>
        </header>
        <main id="main-content">@yield('content')</main>
        <footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-5 py-8 text-sm text-slate-600 dark:text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} Enterprise Tasks. Built for focused work.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('about') }}" class="hover:text-white dark:hover:text-cyan-300">About</a>
                    <a href="{{ route('faq') }}" class="hover:text-white dark:hover:text-cyan-300">FAQ</a>
                    <a href="{{ route('terms') }}" class="hover:text-white dark:hover:text-cyan-300">Terms</a>
                    <a href="{{ route('privacy') }}" class="hover:text-white dark:hover:text-cyan-300">Privacy</a>
                    <a href="mailto:{{ config('app.seo.contact_email') }}" class="hover:text-cyan-300">{{ config('app.seo.contact_email') }}</a>
                    @if (config('app.seo.contact_phone'))
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('app.seo.contact_phone')) }}" class="hover:text-cyan-300">{{ config('app.seo.contact_phone') }}</a>
                    @endif
                </div>
            </div>
        </footer>
        <x-site-enhancements />
    </body>
</html>