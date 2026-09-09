<x-guest-layout>
    <header class="mb-6">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Verify your email</h1>
        <p class="mt-2 text-base leading-relaxed text-slate-600 dark:text-slate-300">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </header>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 rounded-xl border border-emerald-300 bg-emerald-50 p-4 text-base font-medium text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300" role="status" aria-live="polite">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button class="text-base">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="inline-flex min-h-[44px] min-w-[44px] items-center rounded-md px-3 text-base font-medium text-slate-700 underline underline-offset-2 hover:text-slate-950 dark:text-slate-200 dark:hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-900">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
