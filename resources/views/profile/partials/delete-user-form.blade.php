<section class="space-y-4">
    <header>
        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-base leading-relaxed text-slate-700 dark:text-slate-300">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <div class="mt-4">
        <x-danger-button
            class="min-h-[44px] min-w-[44px]"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Delete Account') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-3 text-base leading-relaxed text-slate-700 dark:text-slate-300">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-4 space-y-1">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full text-base leading-relaxed sm:w-3/4"
                    placeholder="{{ __('Password') }}"
                    aria-describedby="delete-password-error"
                    aria-invalid="{{ $errors->userDeletion->has('password') ? 'true' : 'false' }}"
                />

                <x-input-error id="delete-password-error" :messages="$errors->userDeletion->get('password')" class="mt-2 text-base" />
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-3">
                <x-secondary-button class="min-h-[44px] min-w-[44px]" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="min-h-[44px] min-w-[44px]">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
