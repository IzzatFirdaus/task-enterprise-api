@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col justify-between gap-4 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:p-8">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-800 ring-1 ring-inset ring-cyan-700/10 mb-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-cyan-600"></span>
                    Account Settings
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-950">Profile &amp; Credentials</h1>
                <p class="mt-1 text-sm text-slate-500 max-w-xl">Manage your identity, security credentials, and workspace preferences.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-2xs hover:bg-slate-50">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
