<x-guest-layout>
    <header class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Reset your password</h1>
        <p class="mt-2 text-base leading-relaxed text-slate-600 dark:text-slate-300">
            {{ __('Forgot your password? Enter your email address to receive a password reset link.') }}
        </p>
    </header>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="email-error" :messages="$errors->get('email')" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center text-base">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>

        <div class="border-t border-slate-100 pt-5 text-center dark:border-slate-700">
            <a href="{{ route('login') }}" class="inline-flex min-h-[44px] min-w-[44px] items-center px-3 text-base font-semibold text-teal-700 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">
                &larr; Back to sign in
            </a>
        </div>
    </form>
</x-guest-layout>
