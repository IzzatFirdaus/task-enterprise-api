@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-800 ring-1 ring-inset ring-purple-700/10 mb-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-purple-600"></span>
                    Super Admin Security Control
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950">System Configuration</h1>
                <p class="text-xs text-slate-500">Configure global parameters, operational boundaries, and system availability states.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Application Identity -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-base font-semibold text-slate-900">Application Identity</h2>
                    <p class="text-xs text-slate-500">Global site naming and system administrative routing.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Site Name <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="site_name"
                            value="{{ old('site_name', config('app.name')) }}"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                            required
                        />
                        @error('site_name')
                            <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Admin Contact Email <span class="text-rose-500">*</span></label>
                        <input
                            type="email"
                            name="admin_email"
                            value="{{ old('admin_email', 'admin@example.com') }}"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                            required
                        />
                        @error('admin_email')
                            <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Operational Controls -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-base font-semibold text-slate-900">Operational Guardrails</h2>
                    <p class="text-xs text-slate-500">Maintenance mode control and user registration volume ceilings.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Maintenance Mode</label>
                        <select
                            name="maintenance_mode"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                        >
                            <option value="0" {{ old('maintenance_mode', config('app.env') !== 'production' ? '0' : '1') === '0' ? 'selected' : '' }}>Off (Normal Availability)</option>
                            <option value="1" {{ old('maintenance_mode', config('app.env') === 'production' ? '1' : '0') === '1' ? 'selected' : '' }}>On (Restricted Access)</option>
                        </select>
                        @error('maintenance_mode')
                            <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Max System Users Limit</label>
                        <input
                            type="number"
                            name="max_users"
                            value="{{ old('max_users', 500) }}"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                        />
                        @error('max_users')
                            <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Save Action -->
            <div class="flex justify-end gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-slate-900"
                >
                    Save System Settings
                </button>
            </div>
        </form>
    </div>
@endsection
