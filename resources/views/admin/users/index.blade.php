@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950 dark:text-white">User Management</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Search, inspect roles, and administer system access permissions.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-xl bg-slate-50 dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                Total Users: <span class="font-bold text-slate-900 dark:text-white">{{ $users->total() }}</span>
            </div>
        </div>

        <!-- Users Table Card -->
        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-700 text-[11px] font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                            <th scope="col" class="pb-3 pr-4">User</th>
                            <th scope="col" class="pb-3 px-4">Roles</th>
                            <th scope="col" class="pb-3 px-4">Status</th>
                            <th scope="col" class="pb-3 px-4">Joined</th>
                            <th scope="col" class="pb-3 pl-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($users as $user)
                            <tr class="group transition hover:bg-slate-50/80 dark:hover:bg-slate-700/50">
                                <!-- User Identity -->
                                <td class="py-3.5 pr-4 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-xs font-bold text-slate-700 dark:text-slate-200">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900 dark:text-slate-100">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Roles -->
                                <td class="py-3.5 px-4 align-middle">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse ($user->roles as $role)
                                            <x-badge type="role" :value="$role->name" size="sm" />
                                        @empty
                                            <span class="text-xs text-slate-400 dark:text-slate-500">No role</span>
                                        @endforelse
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
                                    <x-badge type="account_status" :value="$user->is_suspended ? 'suspended' : 'active'" size="sm" />
                                </td>

                                <!-- Joined Date -->
                                <td class="py-3.5 px-4 align-middle whitespace-nowrap text-xs text-slate-500 dark:text-slate-400">
                                    {{ $user->created_at?->format('M d, Y') ?? 'N/A' }}
                                </td>

                                <!-- Actions -->
                                <td class="py-3.5 pl-4 align-middle text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a
                                            href="{{ route('admin.users.edit', $user) }}"
                                            class="inline-flex items-center gap-1 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-2.5 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-300 shadow-2xs transition hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white"
                                        >
                                            <svg class="h-3.5 w-3.5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Edit
                                        </a>

                                        @if ($user->is_suspended)
                                            <form method="POST" action="{{ route('admin.users.unsuspend', $user) }}" class="inline">
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 px-2.5 py-1.5 text-xs font-medium text-emerald-700 dark:text-emerald-300 shadow-2xs hover:bg-emerald-100 dark:hover:bg-emerald-900/60"
                                                >
                                                    Unsuspend
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="reason" value="Admin suspension review">
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-amber-200 dark:border-amber-800/60 bg-amber-50 dark:bg-amber-950/40 px-2.5 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300 shadow-2xs hover:bg-amber-100 dark:hover:bg-amber-900/60"
                                                >
                                                    Suspend
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-xs text-slate-500 dark:text-slate-400">
                                    No user accounts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="mt-6 border-t border-slate-100 dark:border-slate-700 pt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
