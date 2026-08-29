<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center gap-1.5 rounded-full bg-slate-900 dark:bg-slate-800 border border-slate-700 px-3 py-1 text-[11px] font-semibold text-cyan-400 mb-2">
            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
            Enterprise Security
        </div>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Administrator Sign In</h1>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Restricted portal for administrative operations &amp; audit oversight.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
        @csrf

        <div class="space-y-1">
            <x-input-label for="email" :value="__('Admin Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@enterprise.internal" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="space-y-1">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-cyan-600 focus:ring-cyan-500">
                <span class="ms-2 text-xs text-slate-600 dark:text-slate-300 font-medium">Remember terminal session</span>
            </label>
        </div>

        <div class="pt-2">
            <button
                type="submit"
                class="inline-flex w-full items-center justify-center rounded-xl bg-slate-950 dark:bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700 dark:hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
            >
                Authenticate as Admin
            </button>
        </div>

        <div class="border-t border-slate-100 dark:border-slate-700 pt-4 text-center">
            <a href="{{ route('login') }}" class="text-xs font-semibold text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300">
                &larr; Return to Workspace User Login
            </a>
        </div>
    </form>
</x-guest-layout>
