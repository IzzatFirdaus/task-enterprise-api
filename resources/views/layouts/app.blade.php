<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-user-pref="{{ auth()->check() ? (auth()->user()->dark_mode ? 'true' : 'false') : 'null' }}" class="h-full bg-slate-50 dark:bg-slate-950">
    @php
        $pageTitles = [
            'dashboard' => 'Dashboard',
            'profile.edit' => 'Profile Settings',
        ];
        $pageDescriptions = [
            'dashboard' => 'Review your task workload, priorities, and progress in Enterprise Tasks.',
            'profile.edit' => 'Manage your Enterprise Tasks profile and account security settings.',
        ];
        $routeName = request()->route()?->getName();
        $pageTitle = $pageTitles[$routeName] ?? 'Workspace';
        $pageDescription = $pageDescriptions[$routeName] ?? 'Organize operational work and keep team tasks moving with Enterprise Tasks.';
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index,follow">
        <link rel="canonical" href="{{ request()->url() }}">
        <meta name="description" content="@yield('description', $pageDescription)">
        <title>@yield('title', $pageTitle) | {{ config('app.name', 'Enterprise Tasks') }}</title>
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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="app-shell flex min-h-full flex-col font-sans text-slate-900 dark:text-slate-100 antialiased selection:bg-teal-700 selection:text-white" x-data="{ mobileMenuOpen: false }">
        <a href="#main-content" class="skip-link">
            Skip to main content
        </a>

        <!-- Top Navigation -->
        <header class="sticky top-0 z-40 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex items-center gap-6">
                    <a href="{{ route('dashboard') }}" class="group flex min-h-[44px] items-center gap-3 rounded-xl p-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-900" aria-label="Enterprise Tasks Dashboard">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-teal-700 text-xs font-bold text-white shadow-xs">ET</span>
                        <span class="flex flex-col">
                            <span class="text-sm font-bold leading-none text-slate-950 dark:text-white">Enterprise Tasks</span>
                            <span class="mt-1 text-xs font-medium leading-none text-slate-500 dark:text-slate-400">Personal work queue</span>
                        </span>
                    </a>
                </div>

                @auth
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:gap-5">
                        <nav class="flex items-center gap-1 text-sm font-semibold" aria-label="Primary navigation">
                            <a href="{{ route('dashboard') }}" class="inline-flex min-h-[44px] items-center rounded-lg px-3 py-2 transition {{ request()->routeIs('dashboard') ? 'bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-950 dark:hover:text-white' }} focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                                Dashboard
                            </a>
                            <a href="{{ route('tasks.index') }}" class="inline-flex min-h-[44px] items-center rounded-lg px-3 py-2 transition {{ request()->routeIs('tasks.*') ? 'bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-950 dark:hover:text-white' }} focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                                Tasks
                            </a>
                            <a href="{{ route('profile.edit') }}" class="inline-flex min-h-[44px] items-center rounded-lg px-3 py-2 transition {{ request()->routeIs('profile.*') ? 'bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-950 dark:hover:text-white' }} focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                                Profile
                            </a>
                            @if (auth()->user()->hasAnyRole(['admin', 'super_admin', 'moderator']))
                                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('admin.tasks.index') }}" class="ml-2 inline-flex min-h-[44px] items-center gap-1.5 rounded-lg bg-slate-900 dark:bg-slate-800 border border-slate-700 dark:border-slate-600 px-3.5 py-2 text-xs font-bold text-white shadow-xs transition hover:bg-teal-700 dark:hover:bg-teal-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2">
                                    <svg class="h-3.5 w-3.5 text-teal-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                    Admin Panel
                                </a>
                            @endif
                        </nav>

                        <!-- Dark Mode Toggle Component -->
                        <livewire:dark-mode-toggle />

                        <div class="h-5 w-px bg-slate-200 dark:bg-slate-700" aria-hidden="true"></div>

                        <!-- User Profile Area -->
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 dark:bg-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200" aria-hidden="true">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-rose-600 dark:hover:text-rose-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-600" title="Log out" aria-label="Log out">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Navigation Controls -->
                    <div class="flex items-center gap-2 md:hidden">
                        <livewire:dark-mode-toggle />

                        <button
                            type="button"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-lg p-2.5 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-950 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600"
                            :aria-expanded="mobileMenuOpen"
                            aria-label="Toggle navigation menu"
                        >
                            <svg class="h-6 w-6" x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <svg class="h-6 w-6" x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu Dropdown -->
            @auth
                <div
                    x-show="mobileMenuOpen"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    data-focus-trap
                    class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 pt-2 pb-4 shadow-lg md:hidden"
                >
                    <nav class="space-y-1" aria-label="Mobile navigation">
                        <a href="{{ route('dashboard') }}" class="flex min-h-[44px] items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('tasks.index') }}" class="flex min-h-[44px] items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('tasks.*') ? 'bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            Tasks
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex min-h-[44px] items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('profile.*') ? 'bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300' : 'text-slate-800 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            Profile
                        </a>
                        @if (auth()->user()->hasAnyRole(['admin', 'super_admin', 'moderator']))
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('admin.tasks.index') }}" class="flex min-h-[44px] items-center gap-2 rounded-lg bg-slate-900 dark:bg-slate-800 border border-slate-700 px-3 py-2.5 text-sm font-bold text-white hover:bg-teal-700 dark:hover:bg-teal-600">
                                <svg class="h-4 w-4 text-teal-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                                Switch to Admin Panel
                            </a>
                        @endif
                    </nav>

                    <div class="mt-4 border-t border-slate-100 dark:border-slate-800 pt-3">
                        <div class="flex items-center justify-between px-3 py-2">
                            <div class="flex items-center gap-2.5">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 dark:bg-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200" aria-hidden="true">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-950 dark:text-slate-100">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-slate-600 dark:text-slate-400">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-800 dark:text-slate-300 hover:bg-rose-50 dark:hover:bg-rose-950/50 hover:text-rose-600 dark:hover:text-rose-400">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </header>

        <!-- Flash Message Banners -->
        @if (session('success'))
            <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 rounded-xl border border-emerald-300 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/40 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 shadow-xs" role="status" aria-live="polite">
                    <svg class="h-5 w-5 shrink-0 text-emerald-700 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('status') && session('status') !== 'profile-updated')
            <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 rounded-xl border border-teal-300 dark:border-teal-800 bg-teal-50 dark:bg-teal-950/40 px-4 py-3 text-sm text-teal-800 dark:text-teal-300 shadow-xs" role="status" aria-live="polite">
                    <svg class="h-5 w-5 shrink-0 text-teal-700 dark:text-teal-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">{{ session('status') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 rounded-xl border border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/40 px-4 py-3 text-sm text-rose-800 dark:text-rose-300 shadow-xs" role="alert">
                    <svg class="h-5 w-5 shrink-0 text-rose-700 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Main Content Landmark -->
        <main id="main-content" class="flex-1" tabindex="-1">
            @yield('content')
        </main>

        <!-- Application Footer -->
        <footer class="border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 py-6 text-center text-xs text-slate-600 dark:text-slate-400">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col items-center justify-center gap-2 sm:flex-row sm:gap-4">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Enterprise Tasks') }}. All rights reserved.</p>
                    <a href="mailto:{{ config('app.seo.contact_email') }}" class="font-semibold text-teal-700 hover:underline dark:text-teal-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 rounded-sm">
                        {{ config('app.seo.contact_email') }}
                    </a>
                    @if (config('app.seo.contact_phone'))
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('app.seo.contact_phone')) }}" class="font-semibold text-teal-700 hover:underline dark:text-teal-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 rounded-sm">
                            {{ config('app.seo.contact_phone') }}
                        </a>
                    @endif
                    <a href="{{ route('cookie-policy') }}" class="font-semibold text-teal-700 hover:underline dark:text-teal-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 rounded-sm">
                        Cookie Policy
                    </a>
                    <a href="{{ route('terms') }}" class="font-semibold text-teal-700 hover:underline dark:text-teal-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 rounded-sm">
                        Terms
                    </a>
                </div>
            </div>
        </footer>

        <x-site-enhancements />

        @livewireScripts
    </body>
</html>
