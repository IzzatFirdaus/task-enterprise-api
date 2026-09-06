<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-[44px] items-center justify-center rounded-xl bg-teal-700 dark:bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition hover:bg-teal-800 dark:hover:bg-teal-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-950 active:bg-teal-900 dark:active:bg-teal-700 disabled:opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
