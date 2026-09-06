@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-teal-600 dark:border-teal-400 text-start text-base font-medium text-teal-800 dark:text-teal-300 bg-teal-50/70 dark:bg-teal-950/50 focus:outline-none focus:text-teal-900 focus:bg-teal-100 dark:focus:bg-teal-950 focus:border-teal-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600 focus:outline-none focus:text-slate-800 dark:focus:text-slate-200 focus:bg-slate-50 dark:focus:bg-slate-800 focus:border-slate-300 dark:focus:border-slate-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
