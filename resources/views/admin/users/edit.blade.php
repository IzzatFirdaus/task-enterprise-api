@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <!-- Header with Breadcrumb -->
        <div class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:flex-row sm:items-center">
            <div>
                <nav class="flex items-center gap-1.5 text-xs text-slate-500 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('admin.users.index') }}" class="hover:text-slate-900 transition">User Management</a>
                    <span>/</span>
                    <span class="font-medium text-slate-900">Edit User</span>
                </nav>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-950">Edit User: {{ $user->name }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50">
                    &larr; Back to Users
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: User Details -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-base font-semibold text-slate-900">User Identity</h2>
                    <p class="text-xs text-slate-500">Core identity and contact information.</p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Full Name <span class="text-rose-500">*</span></label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                            required
                        />
                        @error('name')
                            <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Email Address <span class="text-rose-500">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                            required
                        />
                        @error('email')
                            <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Role Assignment -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-base font-semibold text-slate-900">Role Permissions</h2>
                    <p class="text-xs text-slate-500">Assign role access levels and capability policies.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($roles as $role)
                        <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 p-4 transition hover:border-slate-300 hover:bg-slate-50/50 has-checked:border-cyan-600 has-checked:bg-cyan-50/40">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles', $user->roles->pluck('id')->all()), false) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-slate-300 text-cyan-700 focus:ring-cyan-500"
                            />
                            <div>
                                <div class="text-sm font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $role->name)) }}</div>
                                <div class="text-[11px] text-slate-500">Access role</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                @enderror
                @error('roles.*')
                    <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <!-- Section 3: Account Status & Suspension -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-base font-semibold text-slate-900">Account Access Status</h2>
                    <p class="text-xs text-slate-500">Temporarily suspend account access or restore active standing.</p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-4 space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_suspended"
                            value="1"
                            {{ old('is_suspended', $user->is_suspended) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500"
                        />
                        <span class="text-sm font-semibold text-slate-900">Suspend Account Access</span>
                    </label>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Suspension Reason</label>
                        <textarea
                            name="suspension_reason"
                            rows="2"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 shadow-xs focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20"
                            placeholder="Provide administrative notes for this suspension..."
                        >{{ old('suspension_reason', $user->suspension_reason) }}</textarea>
                        @error('suspension_reason')
                            <p class="text-xs font-medium text-rose-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-2xs hover:bg-slate-50">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-slate-900">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
