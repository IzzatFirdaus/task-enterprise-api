@props([
    'title' => null,
    'description' => null,
    'padding' => 'default',
])

@php
    $paddingClasses = match ($padding) {
        'none' => '',
        'sm' => 'p-4 sm:p-5',
        'lg' => 'p-6 sm:p-8',
        default => 'p-5 sm:p-6',
    };
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-800 shadow-sm transition duration-150']) }}>
    @if ($title || isset($header) || $description)
        <div class="border-b border-slate-100 dark:border-slate-700 px-5 py-4 sm:px-6">
            @if (isset($header))
                {{ $header }}
            @else
                <div class="flex items-center justify-between">
                    <div>
                        @if ($title)
                            <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100 sm:text-lg">{{ $title }}</h3>
                        @endif
                        @if ($description)
                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400 sm:text-sm">{{ $description }}</p>
                        @endif
                    </div>
                    @if (isset($action))
                        <div class="flex items-center gap-2">
                            {{ $action }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $paddingClasses }}">
        {{ $slot }}
    </div>

    @if (isset($footer))
        <div class="border-t border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50 px-5 py-3.5 sm:px-6 rounded-b-xl">
            {{ $footer }}
        </div>
    @endif
</div>
