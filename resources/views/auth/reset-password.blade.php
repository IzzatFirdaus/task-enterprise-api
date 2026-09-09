<x-guest-layout>
    <header class="mb-6 text-center">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Create new password</h1>
        <p class="mt-2 text-base leading-relaxed text-slate-600 dark:text-slate-300">Set a new secure password for your account.</p>
    </header>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" aria-describedby="email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="email-error" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" aria-describedby="password-error" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />
            <x-input-error id="password-error" :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation" required autocomplete="new-password" aria-describedby="password-confirmation-error" aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}" />
            <x-input-error id="password-confirmation-error" :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center text-base">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>

        <div class="border-t border-slate-100 pt-5 text-center dark:border-slate-700">
            <p class="text-sm leading-relaxed text-slate-500 dark:text-slate-400">
                By resetting your password, you agree to our
                <a href="{{ route('terms') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white">Terms of Service</a>
                and
                <a href="{{ route('privacy') }}" class="font-semibold text-slate-800 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white">Privacy Policy</a>.
            </p>
        </div>
    </form>
</x-guest-layout>
