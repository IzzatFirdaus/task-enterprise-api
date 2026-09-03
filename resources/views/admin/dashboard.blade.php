@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <!-- Hero Header -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center sm:p-8">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-cyan-50 dark:bg-cyan-950/60 px-3 py-1 text-xs font-semibold text-cyan-800 dark:text-cyan-400 ring-1 ring-inset ring-cyan-700/10 dark:ring-cyan-500/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-cyan-600 dark:bg-cyan-400"></span>
                    System Overview
                </div>
                <h1 class="mt-2 text-2xl sm:text-3xl font-bold tracking-tight text-slate-950 dark:text-white">Administrative Dashboard</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 max-w-xl">Enterprise management insights, workload health, and administrative audit streams.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-800/80 px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-400 shadow-xs">
                <svg class="h-4 w-4 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                <span>{{ now()->format('l, M j, Y') }}</span>
            </div>
        </div>

        <!-- 4 Metric Cards -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <!-- Total Users -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Users</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $stats['total_users'] ?? 0 }}</span>
                    <span class="text-xs text-slate-400 dark:text-slate-500">registered accounts</span>
                </div>
            </div>

            <!-- Total Tasks -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-cyan-700 dark:text-cyan-400">Total Tasks</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-700 dark:text-cyan-300">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-cyan-800 dark:text-cyan-400">{{ $stats['total_tasks'] ?? 0 }}</span>
                    <span class="text-xs text-cyan-600/70 dark:text-cyan-500/70">system workload</span>
                </div>
            </div>

            <!-- Suspended Users -->
            <div class="rounded-2xl border border-rose-200/80 dark:border-rose-900/60 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-rose-300 dark:hover:border-rose-700 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-rose-700 dark:text-rose-400">Suspended Users</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-rose-700 dark:text-rose-400">{{ $stats['suspended_users'] ?? 0 }}</span>
                    <span class="text-xs text-rose-600/70 dark:text-rose-500/70">locked accounts</span>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-5 shadow-xs transition hover:border-slate-300 dark:hover:border-slate-700 hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-purple-700 dark:text-purple-400">Recent Activity</span>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-purple-800 dark:text-purple-400">{{ $stats['recent_activity'] ?? 0 }}</span>
                    <span class="text-xs text-purple-600/70 dark:text-purple-500/70">logged events</span>
                </div>
            </div>
        </div>

        <!-- Task Status Breakdown & Quick Actions Grid -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Breakdown Progress Bars -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Task Status Distribution</h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Total: {{ $stats['total_tasks'] ?? 0 }}</span>
                </div>
                <div class="mt-5 space-y-4">
                    @foreach ($stats['tasks_by_status'] ?? [] as $status => $count)
                        @php
                            $statusWidth = min(($count / max(1, (int) ($stats['total_tasks'] ?? 1))) * 100, 100);
                            $color = match ($status) {
                                'completed' => 'bg-emerald-500',
                                'in_progress' => 'bg-cyan-500',
                                default => 'bg-amber-500',
                            };
                        @endphp
                        <div>
                            <div class="mb-1.5 flex items-center justify-between text-xs font-medium text-slate-700 dark:text-slate-300">
                                <div class="flex items-center gap-2">
                                    <span class="h-2 w-2 rounded-full {{ $color }}"></span>
                                    <span class="capitalize">{{ str_replace('_', ' ', $status) }}</span>
                                </div>
                                <span class="text-slate-500 dark:text-slate-400 font-semibold">{{ $count }} ({{ number_format($statusWidth, 0) }}%)</span>
                            </div>
                            <div class="h-2.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700 ring-1 ring-slate-200/60 dark:ring-slate-600 ring-inset">
                                <div
                                    class="h-full rounded-full {{ $color }} transition-all duration-500"
                                    @style(['width' => $statusWidth . '%'])
                                ></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Action Cards -->
            <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Quick Actions</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Fast access to admin modules.</p>
                </div>
                <div class="mt-4 space-y-2.5">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-cyan-600 dark:hover:border-cyan-500 hover:bg-cyan-50/50 dark:hover:bg-cyan-950/40 hover:text-cyan-800 dark:hover:text-cyan-300">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Manage User Accounts
                            </span>
                            <span class="text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300">&rarr;</span>
                        </a>
                    @endif

                    @if (auth()->user()->canModerate())
                        <a href="{{ route('admin.tasks.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-cyan-600 dark:hover:border-cyan-500 hover:bg-cyan-50/50 dark:hover:bg-cyan-950/40 hover:text-cyan-800 dark:hover:text-cyan-300">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                Task Moderation Queue
                            </span>
                            <span class="text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300">&rarr;</span>
                        </a>
                    @endif

                    @if (auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.audit-logs.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-cyan-600 dark:hover:border-cyan-500 hover:bg-cyan-50/50 dark:hover:bg-cyan-950/40 hover:text-cyan-800 dark:hover:text-cyan-300">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Inspect Audit Trails
                            </span>
                            <span class="text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300">&rarr;</span>
                        </a>

                        <a href="{{ route('admin.settings.index') }}" class="group flex items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-cyan-600 dark:hover:border-cyan-500 hover:bg-cyan-50/50 dark:hover:bg-cyan-950/40 hover:text-cyan-800 dark:hover:text-cyan-300">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Configure System
                            </span>
                            <span class="text-slate-400 group-hover:text-cyan-700 dark:group-hover:text-cyan-300">&rarr;</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity Audit Stream -->
        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Recent Administrative Actions</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Live stream of recorded administrative operations.</p>
                </div>
                @if (auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.audit-logs.index') }}" class="text-xs font-semibold text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300">
                        View All Audit Logs &rarr;
                    </a>
                @endif
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse ($recentActivity as $activity)
                    <div class="flex items-center justify-between py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold">
                                {{ strtoupper(substr($activity->action, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $activity->admin?->name ?? 'System Admin' }}</span> · {{ $activity->model_type ?? 'Entity' }} #{{ $activity->model_id ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 dark:text-slate-500">
                            {{ $activity->created_at?->diffForHumans() ?? 'recently' }}
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-500 dark:text-slate-400">
                        No administrative operations have been logged yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
