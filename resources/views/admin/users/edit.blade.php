@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <!-- Header with Breadcrumb -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <nav class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-slate-900 dark:hover:text-white transition">User Management</a>
                    <span>/</span>
                    <span class="font-medium text-slate-900 dark:text-slate-100">Edit User</span>
                </nav>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950 dark:text-white">Edit User: {{ $user->name }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 shadow-2xs hover:bg-slate-50 dark:hover:bg-slate-700">
                    &larr; Back to Users
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: User Details -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">User Identity</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Name and email address.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Full Name <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-teal-600 dark:focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-600/20 dark:focus:ring-teal-400/20"
                            required
                        />
                        @error('name')
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Email Address <span class="text-rose-500">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-teal-600 dark:focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-600/20 dark:focus:ring-teal-400/20"
                            required
                        />
                        @error('email')
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Role Assignment -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Role Permissions</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Assign roles to this user.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($roles as $role)
                        <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 dark:border-slate-700 p-4 transition hover:border-slate-300 dark:hover:border-slate-600 hover:bg-slate-50/50 dark:hover:bg-slate-700/40 has-checked:border-teal-600 dark:has-checked:border-teal-500 has-checked:bg-teal-50/40 dark:has-checked:bg-teal-950/40">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles', $user->roles->pluck('id')->all()), false) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 text-teal-700 dark:text-teal-500 focus:ring-teal-500"
                            />
                            <div>
                                <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400">Access role</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                @enderror
                @error('roles.*')
                    <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <!-- Section 3: Account Status & Suspension -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Account Access Status</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Suspend or restore this account.</p>
                </div>

                <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-900/60 p-4 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_suspended"
                            value="1"
                            {{ old('is_suspended', $user->is_suspended) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 text-rose-600 focus:ring-rose-500"
                        />
                        <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">Suspend Account Access</span>
                    </label>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Suspension Reason</label>
                        <textarea
                            name="suspension_reason"
                            rows="2"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3.5 py-2 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 shadow-xs focus:border-teal-600 dark:focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-600/20 dark:focus:ring-teal-400/20"
                            placeholder="Reason for suspension (optional)"
                        >{{ old('suspension_reason', $user->suspension_reason) }}</textarea>
                        @error('suspension_reason')
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-200 shadow-2xs hover:bg-slate-50 dark:hover:bg-slate-700">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 hover:bg-teal-800 dark:bg-teal-600 dark:hover:bg-teal-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
