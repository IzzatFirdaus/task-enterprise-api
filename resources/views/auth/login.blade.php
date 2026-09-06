<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Sign in to your account</h1>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Access your tasks and workspace.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@company.com" aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="email-error" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="inline-flex min-h-11 items-center text-xs font-semibold text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-500" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" aria-describedby="password-error" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />
            <x-input-error id="password-error" :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex min-h-11 items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="h-5 w-5 rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-cyan-700 dark:text-cyan-500 focus:ring-cyan-500" name="remember">
                <span class="ms-2 text-xs text-slate-600 dark:text-slate-300 font-medium">{{ __('Keep me signed in') }}</span>
            </label>
        </div>

        <!-- Sign In Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <!-- Links -->
        <div class="border-t border-slate-100 dark:border-slate-700 pt-4 text-center space-y-2">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Don't have an account?
                <a class="inline-flex min-h-11 items-center font-semibold text-cyan-700 dark:text-cyan-400 hover:text-cyan-800 dark:hover:text-cyan-300 ml-1" href="{{ route('register') }}">
                    Create an account
                </a>
            </p>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                Are you an administrator?
                <a class="inline-flex min-h-11 items-center font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white ml-1" href="{{ route('admin.login') }}">
                    Enterprise Admin Login &rarr;
                </a>
            </p>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                By signing in, you agree to our
                <a href="{{ route('terms') }}" class="font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white ml-1">Terms of Service</a>
                and
                <a href="{{ route('privacy') }}" class="font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white ml-1">Privacy Policy</a>.
            </p>
        </div>
    </form>
</x-guest-layout>
