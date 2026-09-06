@props(['rows' => 5, 'columns' => 4])

<div {{ $attributes->merge(['class' => 'animate-pulse space-y-3']) }} aria-busy="true" aria-label="Loading content" role="status">
    @for ($i = 0; $i < $rows; $i++)
        <div class="flex items-center gap-4 py-3">
            @for ($j = 0; $j < $columns; $j++)
                <div class="h-4 w-20 rounded bg-slate-200 dark:bg-slate-700"></div>
            @endfor
        </div>
    @endfor
    <span class="sr-only">Loading...</span>
</div>
