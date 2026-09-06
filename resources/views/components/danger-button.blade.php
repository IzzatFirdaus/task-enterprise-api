<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-[44px] items-center justify-center px-4 py-2.5 bg-rose-700 dark:bg-rose-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider shadow-xs hover:bg-rose-800 dark:hover:bg-rose-500 active:bg-rose-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-600 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-950 transition ease-in-out duration-150 cursor-pointer']) }}>
    {{ $slot }}
</button>
