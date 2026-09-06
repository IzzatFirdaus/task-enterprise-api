@extends('layouts.app')

@section('title', 'Profile and Security')
@section('description', 'Update your name, email, and password in Enterprise Tasks.')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col justify-between gap-4 border-b border-slate-200 pb-6 dark:border-slate-800 sm:flex-row sm:items-end">
            <div>
                <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400">Account settings</p>
                <h1 class="text-2xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-3xl">Profile and security</h1>
                <p class="mt-1 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300">Update your account information and password.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="inline-flex min-h-[44px] items-center rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-4 py-2.5 text-xs font-semibold text-slate-800 dark:text-slate-200 shadow-xs hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                    &larr; Back to Dashboard
                </a>
            </div>
        </header>

        <div class="divide-y divide-slate-200 rounded-xl border border-slate-200 bg-white dark:divide-slate-800 dark:border-slate-800 dark:bg-slate-900 shadow-xs">
            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
