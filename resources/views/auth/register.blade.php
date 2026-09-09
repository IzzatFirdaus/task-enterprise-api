<x-guest-layout>
    <header class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Create your account</h1>
        <p class="mt-2 text-base leading-relaxed text-slate-600 dark:text-slate-300">Create an account to start tracking your personal work.</p>
    </header>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" aria-describedby="name-error" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" />
            <x-input-error id="name-error" :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="email-error" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" aria-describedby="password-error" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />
            <x-input-error id="password-error" :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" aria-describedby="password-confirmation-error" aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}" />
            <x-input-error id="password-confirmation-error" :messages="$errors->get('password_confirmation')" />
        </div>

        <!-- Consent -->
        <fieldset class="border-0 p-0">
            <legend class="sr-only">Consent to terms</legend>
            <label for="consent" class="flex min-h-[44px] min-w-[44px] cursor-pointer items-start gap-3 text-base leading-relaxed text-slate-700 dark:text-slate-200">
                <input id="consent" type="checkbox" name="consent" required aria-required="true" aria-describedby="consent-error" aria-invalid="{{ $errors->has('consent') ? 'true' : 'false' }}" class="mt-1 h-5 w-5 min-h-[20px] min-w-[20px] rounded border-slate-300 text-teal-700 focus:ring-teal-500 dark:border-slate-600 dark:bg-slate-800" />
                <span>I agree to the <a href="{{ route('terms') }}" class="font-semibold text-teal-700 underline decoration-teal-700/40 underline-offset-2 hover:text-teal-800 dark:text-teal-400 dark:decoration-teal-400/40 dark:hover:text-teal-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">Terms of Service</a> and <a href="{{ route('privacy') }}" class="font-semibold text-teal-700 underline decoration-teal-700/40 underline-offset-2 hover:text-teal-800 dark:text-teal-400 dark:decoration-teal-400/40 dark:hover:text-teal-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-teal-600">Privacy Policy</a>, and consent to processing of my personal data.</span>
            </label>
            <x-input-error id="consent-error" :messages="$errors->get('consent')" />
        </fieldset>

        <!-- Submit Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center text-base">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>

        <!-- Already Registered -->
        <div class="space-y-3 border-t border-slate-100 pt-5 text-center dark:border-slate-700">
            <p class="text-base text-slate-600 dark:text-slate-300">
                Already registered?
                <a class="inline-flex min-h-[44px] min-w-[44px] items-center font-semibold text-teal-700 dark:text-teal-300 hover:text-teal-800 dark:hover:text-teal-200" href="{{ route('login') }}">
                    Sign in to your account
                </a>
            </p>
            <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                By creating an account, you agree to our
                <a href="{{ route('terms') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white">Terms of Service</a>
                and
                <a href="{{ route('privacy') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white">Privacy Policy</a>.
            </p>
        </div>
    </form>
</x-guest-layout>
