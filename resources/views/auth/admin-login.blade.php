<x-guest-layout>
    <div class="mb-6 text-center">
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
                <input id="remember" type="checkbox" name="remember" class="h-5 w-5 rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-teal-700 focus:ring-teal-500">
                <span class="ms-2 text-xs text-slate-600 dark:text-slate-300 font-medium">Keep me signed in</span>
            </label>
        </div>

        <div class="pt-2">
            <button
                type="submit"
                class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-teal-700 dark:bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800 dark:hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
            >
                Sign in
            </button>
        </div>

        <div class="border-t border-slate-100 dark:border-slate-700 pt-4 text-center">
            <a href="{{ route('login') }}" class="inline-flex min-h-11 items-center text-xs font-semibold text-teal-700 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                &larr; Return to Workspace User Login
            </a>
        </div>
    </form>
</x-guest-layout>
