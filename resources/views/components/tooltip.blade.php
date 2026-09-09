@props([
    'text' => '',
    'label' => null,
    'id' => null,
])

<span
    @if ($id) id="{{ $id }}" @endif
    data-tooltip="{{ $text }}"
    tabindex="0"
    role="img"
    @if ($label) aria-label="{{ $label }}" @endif
    class="inline-flex min-h-[44px] min-w-[44px] cursor-help items-center justify-center rounded-full border border-slate-300 bg-white text-xs font-bold text-slate-600 transition hover:border-teal-600 hover:text-teal-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:border-teal-500 dark:hover:text-teal-300"
>?</span>
