@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'loading' => null,
])

@php
    $variantClasses = match ($variant) {
        'secondary' => 'bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-slate-950 dark:hover:text-white focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 active:bg-slate-100 dark:active:bg-slate-700 shadow-xs',
        'danger' => 'bg-rose-700 dark:bg-rose-600 text-white hover:bg-rose-800 dark:hover:bg-rose-500 focus-visible:ring-rose-600 dark:focus-visible:ring-rose-400 active:bg-rose-900 shadow-xs',
        'outline' => 'bg-transparent text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-950 dark:hover:text-white focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400',
        'ghost' => 'bg-transparent text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-950 dark:hover:text-white focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400',
        'admin' => 'bg-slate-900 dark:bg-slate-800 text-white hover:bg-teal-700 dark:hover:bg-teal-600 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 active:bg-slate-950 dark:active:bg-slate-700 shadow-xs',
        default => 'bg-teal-700 dark:bg-teal-600 text-white hover:bg-teal-800 dark:hover:bg-teal-500 focus-visible:ring-teal-600 dark:focus-visible:ring-teal-400 active:bg-teal-900 dark:active:bg-teal-700 shadow-xs',
    };

    $sizeClasses = match ($size) {
        'xs' => 'px-3 py-2 text-xs font-semibold rounded-lg gap-1.5 min-h-[44px]',
        'sm' => 'px-3.5 py-2 text-xs sm:text-sm font-semibold rounded-lg gap-1.5 min-h-[44px]',
        'lg' => 'px-5 py-3 text-base font-semibold rounded-xl gap-2 min-h-[48px]',
        default => 'px-4 py-2.5 text-sm font-semibold rounded-xl gap-2 min-h-[44px]',
    };
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "inline-flex items-center justify-center font-semibold transition-all duration-150 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-900 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer select-none {$variantClasses} {$sizeClasses}",
    ]) }}
    @if ($loading)
        wire:loading.attr="disabled"
    @endif
>
    @if ($loading)
        <svg wire:loading wire:target="{{ $loading }}" class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    {{ $slot }}
</button>
