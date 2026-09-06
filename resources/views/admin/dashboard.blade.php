@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-6 border-b border-slate-300 pb-8 dark:border-slate-700 sm:flex-row sm:items-end">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">System activity</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300">Review account access, workload status, and recorded administrative actions.</p>
            </div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ now()->format('l, M j, Y') }}</p>
        </div>

        <!-- 4 Metric Cards -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <!-- Total Users -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Users</span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $stats['total_users'] ?? 0 }}</span>
                    <span class="text-xs text-slate-600 dark:text-slate-400">accounts</span>
                </div>
            </div>

            <!-- Total Tasks -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">Total Tasks</span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-teal-700 dark:text-teal-400">{{ $stats['total_tasks'] ?? 0 }}</span>
                    <span class="text-xs text-teal-700 dark:text-teal-500">tasks</span>
                </div>
            </div>

            <!-- Suspended Users -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-rose-700 dark:text-rose-400">Suspended Users</span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-rose-700 dark:text-rose-400">{{ $stats['suspended_users'] ?? 0 }}</span>
                    <span class="text-xs text-rose-700 dark:text-rose-500">suspended</span>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">Recent Activity</span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-bold tracking-tight text-teal-700 dark:text-teal-400">{{ $stats['recent_activity'] ?? 0 }}</span>
                    <span class="text-xs text-teal-700 dark:text-teal-500">audit events</span>
                </div>
            </div>
        </div>

        <!-- Task Status Breakdown & Quick Actions Grid -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Breakdown Progress Bars -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Task Status Distribution</h2>
                    <span class="text-xs text-slate-600 dark:text-slate-400">Total: {{ $stats['total_tasks'] ?? 0 }}</span>
                </div>
                <div class="mt-5 space-y-4">
                    @foreach ($stats['tasks_by_status'] ?? [] as $status => $count)
                        @php
                            $statusWidth = min(($count / max(1, (int) ($stats['total_tasks'] ?? 1))) * 100, 100);
                            $color = match ($status) {
                                'completed' => 'bg-emerald-500',
                                'in_progress' => 'bg-teal-600',
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
                            <div class="h-2.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-700 ring-1 ring-slate-200 dark:ring-slate-600 ring-inset">
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
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Quick Actions</h2>
                </div>
                <div class="mt-4 space-y-2.5">
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}" class="group flex min-h-[44px] items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50/50 dark:hover:bg-teal-950/40 hover:text-teal-800 dark:hover:text-teal-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-teal-700 dark:group-hover:text-teal-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                User Management
                            </span>
                        </a>
                    @endif

                    @if (auth()->user()->canModerate())
                        <a href="{{ route('admin.tasks.index') }}" class="group flex min-h-[44px] items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50/50 dark:hover:bg-teal-950/40 hover:text-teal-800 dark:hover:text-teal-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-teal-700 dark:group-hover:text-teal-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                Task Moderation
                            </span>
                        </a>
                    @endif

                    @if (auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.audit-logs.index') }}" class="group flex min-h-[44px] items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50/50 dark:hover:bg-teal-950/40 hover:text-teal-800 dark:hover:text-teal-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-teal-700 dark:group-hover:text-teal-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Audit Logs
                            </span>
                        </a>

                        <a href="{{ route('admin.settings.index') }}" class="group flex min-h-[44px] items-center justify-between rounded-xl border border-slate-200 dark:border-slate-700 p-3.5 text-xs font-semibold text-slate-800 dark:text-slate-200 transition hover:border-teal-600 dark:hover:border-teal-500 hover:bg-teal-50/50 dark:hover:bg-teal-950/40 hover:text-teal-800 dark:hover:text-teal-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                            <span class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-slate-400 group-hover:text-teal-700 dark:group-hover:text-teal-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                System Settings
                            </span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity Audit Stream -->
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6">
            <div class="mb-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Recent Administrative Actions</h2>
                </div>
                @if (auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.audit-logs.index') }}" class="rounded-md p-1 text-xs font-semibold text-teal-700 dark:text-teal-400 hover:text-teal-800 dark:hover:text-teal-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                        View all logs
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
                                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $activity->admin?->name ?? 'System Admin' }}</span> &middot; {{ $activity->model_type ?? 'Entity' }} #{{ $activity->model_id ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xs text-slate-600 dark:text-slate-400">
                            {{ $activity->created_at?->diffForHumans() ?? 'recently' }}
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-500 dark:text-slate-400">
                        No administrative operations recorded yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
