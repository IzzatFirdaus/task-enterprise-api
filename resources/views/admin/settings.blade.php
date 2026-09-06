@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col justify-between gap-6 border-b border-slate-300 pb-8 dark:border-slate-700 sm:flex-row sm:items-end">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white">System settings</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Update site identity, contact, and availability settings.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Application Identity -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Application Identity</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Site name and admin contact email.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Site Name <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="site_name"
                            value="{{ old('site_name', config('app.name')) }}"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-teal-600 dark:focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-600/20 dark:focus:ring-teal-400/20"
                            required
                        />
                        @error('site_name')
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Admin Contact Email <span class="text-rose-500">*</span></label>
                        <input
                            type="email"
                            name="admin_email"
                            value="{{ old('admin_email', 'admin@example.com') }}"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-teal-600 dark:focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-600/20 dark:focus:ring-teal-400/20"
                            required
                        />
                        @error('admin_email')
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Operational Controls -->
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">Operational Controls</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Maintenance mode and user registration limits.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Maintenance Mode</label>
                        <select
                            name="maintenance_mode"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-teal-600 dark:focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-600/20 dark:focus:ring-teal-400/20"
                        >
                            <option value="0" {{ old('maintenance_mode', config('app.env') !== 'production' ? '0' : '1') === '0' ? 'selected' : '' }}>Off</option>
                            <option value="1" {{ old('maintenance_mode', config('app.env') === 'production' ? '1' : '0') === '1' ? 'selected' : '' }}>On</option>
                        </select>
                        @error('maintenance_mode')
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">Max System Users Limit</label>
                        <input
                            type="number"
                            name="max_users"
                            value="{{ old('max_users', 500) }}"
                            class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-900 dark:text-slate-100 shadow-xs focus:border-teal-600 dark:focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-600/20 dark:focus:ring-teal-400/20"
                        />
                        @error('max_users')
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Save Action -->
            <div class="flex justify-end gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 hover:bg-teal-800 dark:bg-teal-600 dark:hover:bg-teal-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                >
                    Save settings
                </button>
            </div>
        </form>
    </div>
@endsection
