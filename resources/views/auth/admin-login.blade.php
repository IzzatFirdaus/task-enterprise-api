<x-guest-layout>
    <div class="mb-6 text-center">
        <p class="mb-3 text-xs font-semibold uppercase tracking-[0.14em] text-teal-700 dark:text-teal-300">Administrator access</p>
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Sign in to administration</h1>
        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">Sign in with an authorized admin account.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-4">
        @csrf

        <div class="space-y-1">
            <x-input-label for="email" :value="__('Admin Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@enterprise.internal" aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="email-error" :messages="$errors->get('email')" />
        </div>

        <div class="space-y-1">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" aria-describedby="password-error" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />
            <x-input-error id="password-error" :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between pt-1">
            <label for="remember" class="inline-flex min-h-11 items-center cursor-pointer">
                <input id="remember" type="checkbox" name="remember" class="h-5 w-5 rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-cyan-600 focus:ring-cyan-500">
                <span class="ms-2 text-xs text-slate-600 dark:text-slate-300 font-medium">Keep me signed in</span>
            </label>
        </div>

        <div class="pt-2">
            <button
                type="submit"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-slate-950 dark:bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-cyan-700 dark:hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
            >
                Sign in
            </button>
        </div>

        <div class="border-t border-slate-100 dark:border-slate-700 pt-4 text-center">
            <a href="{{ route('login') }}" class="inline-flex min-h-11 items-center text-xs font-semibold text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500">
                &larr; Return to Workspace User Login
            </a>
        </div>
    </form>
</x-guest-layout>
