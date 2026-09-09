<section>
    <header>
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-base leading-relaxed text-slate-700 dark:text-slate-300">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <div class="space-y-1">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-base leading-relaxed" :value="old('name', $user->name)" required autofocus autocomplete="name" aria-describedby="profile-name-error" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" />
            <x-input-error id="profile-name-error" class="mt-2 text-base" :messages="$errors->get('name')" />
        </div>

        <div class="space-y-1">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-base leading-relaxed" :value="old('email', $user->email)" required autocomplete="username" aria-describedby="profile-email-error" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error id="profile-email-error" class="mt-2 text-base" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-base leading-relaxed text-slate-800 dark:text-slate-200">
                        {{ __('Your email address is unverified.') }}

                        <button type="submit" form="send-verification" class="inline min-h-[44px] min-w-[44px] items-center justify-center rounded-md px-2 py-1 text-base font-semibold text-teal-700 underline transition hover:text-teal-900 dark:text-teal-400 dark:hover:text-teal-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-base font-semibold text-emerald-600 dark:text-emerald-400" role="status" aria-live="polite">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-4 pt-2">
            <x-primary-button class="min-h-[44px] min-w-[44px]">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-base font-semibold text-emerald-600 dark:text-emerald-400"
                    role="status"
                    aria-live="polite"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
