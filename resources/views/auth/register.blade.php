<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Create your account</h1>
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Create your account to get started.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" aria-describedby="name-error" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" />
            <x-input-error id="name-error" :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@company.com" aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="email-error" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" aria-describedby="password-error" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />
            <x-input-error id="password-error" :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" aria-describedby="password-confirmation-error" aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}" />
            <x-input-error id="password-confirmation-error" :messages="$errors->get('password_confirmation')" />
        </div>

        <!-- Consent -->
        <div class="flex items-start gap-2 text-xs text-slate-600 dark:text-slate-400">
            <input id="consent" type="checkbox" name="consent" required class="mt-0.5 h-4 w-4 rounded border-slate-300 text-teal-700 focus:ring-teal-500 dark:border-slate-600 dark:bg-slate-800" aria-describedby="consent-label" />
            <label id="consent-label" for="consent">I agree to the <a href="{{ route('terms') }}" class="underline hover:text-teal-700">Terms of Service</a> and <a href="{{ route('privacy') }}" class="underline hover:text-teal-700">Privacy Policy</a>, and consent to processing of my personal data.</label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <!-- Already Registered -->
        <div class="border-t border-slate-100 dark:border-slate-700 pt-4 text-center space-y-2">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Already registered?
                <a class="inline-flex min-h-11 items-center font-semibold text-teal-700 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200 ml-1" href="{{ route('login') }}">
                    Sign in to your account
                </a>
            </p>
            <p class="text-xs text-slate-400 dark:text-slate-500">
                By creating an account, you agree to our
                <a href="{{ route('terms') }}" class="font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white ml-1">Terms of Service</a>
                and
                <a href="{{ route('privacy') }}" class="font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white ml-1">Privacy Policy</a>.
            </p>
        </div>
    </form>
</x-guest-layout>
