<x-guest-layout>
    <header class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Sign in to your account</h1>
        <p class="mt-2 text-base leading-relaxed text-slate-600 dark:text-slate-300">Access your tasks and workspace.</p>
    </header>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@company.com" aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="email-error" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between gap-2">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="inline-flex min-h-[44px] min-w-[44px] items-center px-2 text-sm font-semibold text-teal-700 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" aria-describedby="password-error" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />
            <x-input-error id="password-error" :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="pt-1">
            <label for="remember_me" class="inline-flex min-h-[44px] min-w-[44px] cursor-pointer items-center gap-3 text-base text-slate-700 dark:text-slate-200">
                <input id="remember_me" type="checkbox" class="h-5 w-5 min-h-[20px] min-w-[20px] rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-teal-700 dark:text-teal-500 focus:ring-teal-500" name="remember">
                <span class="font-medium">{{ __('Keep me signed in') }}</span>
            </label>
        </div>

        <!-- Sign In Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center text-base">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>

        <!-- Links -->
        <div class="space-y-3 border-t border-slate-100 pt-5 text-center dark:border-slate-700">
            <p class="text-base text-slate-600 dark:text-slate-300">
                Don't have an account?
                <a class="inline-flex min-h-[44px] min-w-[44px] items-center font-semibold text-teal-700 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200" href="{{ route('register') }}">
                    Create an account
                </a>
            </p>
            <p class="text-base text-slate-600 dark:text-slate-300">
                Are you an administrator?
                <a class="inline-flex min-h-[44px] min-w-[44px] items-center font-semibold text-slate-800 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white" href="{{ route('admin.login') }}">
                    Enterprise Admin Login
                </a>
            </p>
            <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                By signing in, you agree to our
                <a href="{{ route('terms') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white">Terms of Service</a>
                and
                <a href="{{ route('privacy') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white">Privacy Policy</a>.
            </p>
        </div>
    </form>
</x-guest-layout>
