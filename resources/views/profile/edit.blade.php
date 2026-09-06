@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col justify-between gap-6 border-b border-slate-300 pb-8 dark:border-slate-700 sm:flex-row sm:items-end">
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.14em] text-teal-700 dark:text-teal-300">Account settings</p>
                <h1 class="text-3xl font-bold tracking-tight text-slate-950 dark:text-white sm:text-4xl">Profile and security</h1>
                <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-300">Update your name, email, and password.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="rounded-md border border-slate-400 dark:border-slate-600 bg-transparent px-3.5 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                    &larr; Back to Dashboard
                </a>
            </div>
        </div>

        <div class="divide-y divide-slate-300 border-y border-slate-300 bg-white dark:divide-slate-700 dark:border-slate-700 dark:bg-slate-900">
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
