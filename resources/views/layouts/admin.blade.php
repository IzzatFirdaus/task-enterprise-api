<!DOCTYPE html>
<html lang="en" data-user-pref="{{ auth()->check() ? (auth()->user()->dark_mode ? 'true' : 'false') : 'null' }}" class="h-full bg-slate-100 dark:bg-slate-900">
    @php
        $pageTitles = [
            'admin.dashboard' => 'Administrative Dashboard',
            'admin.tasks.index' => 'Task Moderation Queue',
            'admin.users.index' => 'User Management',
            'admin.users.edit' => 'Edit User',
            'admin.settings.index' => 'System Settings',
            'admin.audit-logs.index' => 'Audit Logs',
        ];
        $pageDescriptions = [
            'admin.dashboard' => 'Monitor enterprise workload, user access, and administrative activity.',
            'admin.tasks.index' => 'Review and manage tasks across the Enterprise Tasks workspace.',
            'admin.users.index' => 'Manage user accounts, roles, and access status.',
            'admin.users.edit' => 'Update user account details and role assignments.',
            'admin.settings.index' => 'Configure system-wide Enterprise Tasks settings.',
            'admin.audit-logs.index' => 'Inspect the recorded administrative activity history.',
        ];
        $routeName = request()->route()?->getName();
        $pageTitle = $pageTitles[$routeName] ?? 'Administration';
        $pageDescription = $pageDescriptions[$routeName] ?? 'Manage Enterprise Tasks users, workloads, and system operations.';
    @endphp
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $pageDescription }}">
        <title>{{ $pageTitle }} | {{ config('app.name', 'Enterprise Tasks') }}</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <script>
            (function() {
                const stored = localStorage.getItem('darkMode');
                const userPrefValue = document.documentElement.dataset.userPref;
                const userPref = userPrefValue === 'null' ? null : userPrefValue === 'true';
                let isDark = false;
                if (stored !== null) {
                    isDark = stored === 'true';
                } else if (userPref !== null) {
                    isDark = userPref;
                } else {
                    isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                }
                if (isDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="flex min-h-full max-w-full flex-col overflow-x-hidden font-sans text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-900 antialiased selection:bg-cyan-500 selection:text-white" x-data="{ sidebarOpen: false }">
        <!-- Admin Top Navigation -->
        <header class="sticky top-0 z-40 border-b border-slate-800 bg-slate-950 text-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <!-- Mobile Sidebar Toggle -->
                    <button
                        type="button"
                        @click="sidebarOpen = !sidebarOpen"
                        class="rounded-lg p-2 text-slate-400 hover:bg-slate-800 hover:text-white lg:hidden focus:outline-none focus:ring-2 focus:ring-cyan-500"
                        :aria-expanded="sidebarOpen"
                        aria-controls="admin-mobile-drawer"
                        aria-label="Toggle admin sidebar"
                    >
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>

                    <a href="{{ url('/') }}" class="flex items-center gap-2.5 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-600 text-white shadow-sm font-bold text-sm">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold tracking-tight text-white">ENTERPRISE ADMIN</span>
                            <span class="text-[9px] font-semibold uppercase tracking-widest text-cyan-400">Management Suite</span>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-3 text-sm">
                    <!-- Switch to app -->
                    @if (auth()->user()->hasAnyRole(['admin', 'super_admin', 'moderator']))
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 rounded-lg border border-slate-700 bg-slate-800/80 px-3 py-1.5 text-xs font-semibold text-slate-200 transition hover:border-slate-600 hover:bg-slate-700 hover:text-white">
                            <svg class="h-3.5 w-3.5 text-cyan-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                            </svg>
                            Back to Workspace
                        </a>
                    @endif

                    <div class="h-5 w-px bg-slate-700" aria-hidden="true"></div>

                    <!-- Dark Mode Toggle -->
                    <livewire:dark-mode-toggle />

                    <div class="h-5 w-px bg-slate-700" aria-hidden="true"></div>

                    <!-- Current Admin User -->
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-cyan-900 text-xs font-bold text-cyan-200 ring-1 ring-cyan-500/30">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="hidden md:inline text-xs font-medium text-slate-300">{{ auth()->user()->name }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg bg-slate-800 px-3 py-1.5 text-xs font-medium text-slate-300 transition hover:bg-rose-950 hover:text-rose-200 hover:border-rose-800 border border-slate-700">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Admin Body -->
        <div class="mx-auto flex w-full max-w-7xl flex-1 gap-6 px-4 py-8 sm:px-6 lg:px-8">
            <!-- Sidebar Navigation Desktop -->
            <aside class="hidden w-64 shrink-0 lg:block">
                <div class="sticky top-24 space-y-6">
                    <div class="rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-sm">
                        <div class="mb-4 flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-100 dark:bg-cyan-900/50 text-sm font-bold text-cyan-800 dark:text-cyan-300">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="truncate text-sm font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</div>
                                <div class="flex items-center gap-1 mt-0.5">
                                    <x-badge type="role" :value="auth()->user()->isSuperAdmin() ? 'super_admin' : (auth()->user()->isAdmin() ? 'admin' : 'moderator')" size="sm" />
                                </div>
                            </div>
                        </div>

                        <nav class="space-y-1" aria-label="Admin sidebar navigation">
                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 dark:bg-slate-700 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-slate-900 dark:hover:text-white' }}">
                                    <svg class="h-4 w-4 {{ request()->routeIs('admin.dashboard') ? 'text-cyan-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                    Dashboard
                                </a>
                            @endif

                            @if (auth()->user()->canModerate())
                                <a href="{{ route('admin.tasks.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.tasks.*') ? 'bg-slate-900 dark:bg-slate-700 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-slate-900 dark:hover:text-white' }}">
                                    <svg class="h-4 w-4 {{ request()->routeIs('admin.tasks.*') ? 'text-cyan-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                    Task Moderation
                                </a>
                            @endif

                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-slate-900 dark:bg-slate-700 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-slate-900 dark:hover:text-white' }}">
                                    <svg class="h-4 w-4 {{ request()->routeIs('admin.users.*') ? 'text-cyan-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    User Management
                                </a>
                            @endif

                            @if (auth()->user()->isSuperAdmin())
                                <a href="{{ route('admin.settings.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-slate-900 dark:bg-slate-700 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-slate-900 dark:hover:text-white' }}">
                                    <svg class="h-4 w-4 {{ request()->routeIs('admin.settings.*') ? 'text-cyan-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    System Settings
                                </a>
                                <a href="{{ route('admin.audit-logs.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.audit-logs.*') ? 'bg-slate-900 dark:bg-slate-700 text-white shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-slate-900 dark:hover:text-white' }}">
                                    <svg class="h-4 w-4 {{ request()->routeIs('admin.audit-logs.*') ? 'text-cyan-400' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    Audit Logs
                                </a>
                            @endif

                            <div class="pt-3">
                                <hr class="border-slate-100 dark:border-slate-700" />
                            </div>

                            <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/60 hover:text-cyan-800 dark:hover:text-cyan-300 transition">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                </svg>
                                Return to App
                            </a>
                        </nav>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main id="main-content" class="min-w-0 max-w-full flex-1">
                @if (session('status'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-cyan-200 dark:border-cyan-800/60 bg-cyan-50 dark:bg-cyan-950/40 px-4 py-3 text-sm text-cyan-800 dark:text-cyan-300 shadow-sm" role="status">
                        <svg class="h-5 w-5 shrink-0 text-cyan-600 dark:text-cyan-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('status') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-300 shadow-sm" role="status">
                        <svg class="h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-rose-200 dark:border-rose-800/60 bg-rose-50 dark:bg-rose-950/40 px-4 py-3 text-sm text-rose-800 dark:text-rose-300 shadow-sm" role="alert">
                        <svg class="h-5 w-5 shrink-0 text-rose-600 dark:text-rose-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Mobile Drawer Overlay -->
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Mobile Drawer -->
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            id="admin-mobile-drawer"
            data-focus-trap
            class="fixed inset-y-0 left-0 z-50 w-72 max-w-[calc(100vw-2rem)] bg-white dark:bg-slate-900 p-6 shadow-2xl lg:hidden flex flex-col justify-between"
        >
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-700 text-white font-bold text-xs">
                            ET
                        </div>
                        <span class="font-bold text-slate-900 dark:text-white">Admin Navigation</span>
                    </div>
                    <button type="button" @click="sidebarOpen = false" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-slate-200">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="mt-4 space-y-1.5" aria-label="Mobile admin navigation">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            Dashboard
                        </a>
                    @endif
                    @if (auth()->user()->canModerate())
                        <a href="{{ route('admin.tasks.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.tasks.*') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            Task Moderation
                        </a>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            User Management
                        </a>
                    @endif
                    @if (auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.settings.*') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            System Settings
                        </a>
                        <a href="{{ route('admin.audit-logs.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('admin.audit-logs.*') ? 'bg-slate-900 dark:bg-slate-800 text-white' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                            Audit Logs
                        </a>
                    @endif
                </nav>
            </div>

            <div class="border-t border-slate-100 dark:border-slate-800 pt-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-lg bg-slate-100 dark:bg-slate-800 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
                    &larr; Back to App Dashboard
                </a>
            </div>
        </div>

        <x-site-enhancements />

        @livewireScripts
    </body>
</html>
