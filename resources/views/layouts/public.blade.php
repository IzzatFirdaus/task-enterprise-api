<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-950">
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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full bg-slate-950 font-sans text-slate-100 antialiased">
        <a href="#main-content" class="skip-link">Skip to content</a>
        <header class="border-b border-slate-800 bg-slate-950/95">
            <nav class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-5" aria-label="Public navigation">
                <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400" aria-label="Enterprise Tasks home">
                    <span class="grid h-9 w-9 place-items-center rounded-lg bg-cyan-600 text-sm font-bold text-white">ET</span>
                    <span><strong class="block text-sm tracking-wide text-white">Enterprise Tasks</strong><span class="text-xs text-slate-400">Operational clarity</span></span>
                </a>
                <div class="hidden items-center gap-4 text-sm font-semibold text-slate-300 sm:flex">
                    <a href="{{ route('capabilities') }}" class="hidden hover:text-cyan-300 sm:inline">Capabilities</a>
                    <a href="{{ route('blog.index') }}" class="hidden hover:text-cyan-300 sm:inline">Journal</a>
                    <a href="{{ route('login') }}" class="rounded-lg border border-slate-700 px-3 py-2 hover:border-cyan-500 hover:text-white">Sign in</a>
                </div>
                <details class="relative sm:hidden">
                    <summary class="flex min-h-11 cursor-pointer list-none items-center rounded-lg border border-slate-700 px-3 py-2 text-sm font-semibold text-slate-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400" aria-label="Open navigation menu">
                        <span aria-hidden="true">Menu</span>
                    </summary>
                    <div class="absolute right-0 top-14 z-50 w-48 rounded-lg border border-slate-700 bg-slate-900 p-2 text-sm font-semibold text-slate-200 shadow-xl">
                        <a href="{{ route('capabilities') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Capabilities</a>
                        <a href="{{ route('blog.index') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Journal</a>
                        <a href="{{ route('login') }}" class="block rounded-md px-3 py-2.5 hover:bg-slate-800 hover:text-cyan-300">Sign in</a>
                    </div>
                </details>
            </nav>
        </header>
        <main id="main-content">@yield('content')</main>
        <footer class="border-t border-slate-800 bg-slate-950">
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-5 py-8 text-sm text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ date('Y') }} Enterprise Tasks. Built for focused work.</p>
                <div class="flex flex-wrap gap-4"><a href="{{ route('about') }}" class="hover:text-white">About</a><a href="{{ route('terms') }}" class="hover:text-white">Terms</a><a href="mailto:{{ config('app.seo.contact_email') }}" class="hover:text-cyan-300">{{ config('app.seo.contact_email') }}</a></div>
            </div>
        </footer>
        <x-site-enhancements />
    </body>
</html>