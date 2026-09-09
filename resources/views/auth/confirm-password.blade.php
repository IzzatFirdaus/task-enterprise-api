<x-guest-layout>
    <header class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Confirm your password</h1>
        <p class="mt-2 text-base leading-relaxed text-slate-600 dark:text-slate-300">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div class="space-y-1.5">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            aria-describedby="password-error"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />

            <x-input-error id="password-error" :messages="$errors->get('password')" />
        </div>

        <div class="flex justify-end pt-2">
            <x-primary-button class="text-base">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
