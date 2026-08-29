@props([
    'label' => null,
    'for' => null,
    'error' => null,
    'help' => null,
    'required' => false,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <div class="flex items-center justify-between">
            <label @if ($for) for="{{ $for }}" @endif class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                {{ $label }}
                @if ($required)
                    <span class="text-rose-500" aria-hidden="true">*</span>
                    <span class="sr-only">(required)</span>
                @endif
            </label>
            @if (isset($corner))
                {{ $corner }}
            @endif
        </div>
    @endif

    {{ $slot }}

    @if ($help)
        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $help }}</p>
    @endif

    @if ($error)
        @if (is_array($error))
            @foreach ($error as $message)
                <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $message }}</p>
            @endforeach
        @else
            <p class="text-xs font-medium text-rose-600 dark:text-rose-400" role="alert">{{ $error }}</p>
        @endif
    @endif
</div>
