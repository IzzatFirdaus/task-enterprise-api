@props([
    'type' => 'text',
    'rows' => 4,
    'columns' => 4,
    'label' => 'Loading content...',
])

<div {{ $attributes->merge(['class' => 'w-full']) }} aria-busy="true" aria-live="polite" role="status" aria-label="{{ $label }}">
    <span class="sr-only">{{ $label }}</span>

    @if ($type === 'table')
        <!-- Table Skeleton -->
        <div class="overflow-hidden">
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                <!-- Skeleton Table Header -->
                <div class="flex items-center justify-between pb-3 pr-4 border-b border-slate-100 dark:border-slate-700">
                    <div class="h-3.5 w-32 rounded-md skeleton-shimmer"></div>
                    <div class="h-3.5 w-20 rounded-md skeleton-shimmer"></div>
                    <div class="h-3.5 w-24 rounded-md skeleton-shimmer"></div>
                    <div class="h-3.5 w-16 rounded-md skeleton-shimmer"></div>
                </div>

                <!-- Skeleton Table Rows -->
                @for ($i = 0; $i < $rows; $i++)
                    <div class="flex items-center justify-between py-4 gap-4">
                        <div class="flex-1 space-y-2">
                            <div class="h-4 w-3/4 max-w-xs rounded-md skeleton-shimmer"></div>
                            <div class="h-3 w-1/2 max-w-sm rounded-md skeleton-shimmer"></div>
                        </div>
                        <div class="w-24">
                            <div class="h-6 w-20 rounded-full skeleton-shimmer"></div>
                        </div>
                        <div class="w-28 hidden sm:block">
                            <div class="h-3.5 w-24 rounded-md skeleton-shimmer"></div>
                        </div>
                        <div class="flex items-center justify-end gap-2 shrink-0">
                            <div class="h-8 w-14 rounded-lg skeleton-shimmer"></div>
                            <div class="h-8 w-14 rounded-lg skeleton-shimmer"></div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

    @elseif ($type === 'stats')
        <!-- Stats Grid Skeleton -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @for ($i = 0; $i < 4; $i++)
                <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/80 p-5 space-y-3">
                    <div class="h-3 w-24 rounded-md skeleton-shimmer"></div>
                    <div class="h-8 w-16 rounded-md skeleton-shimmer"></div>
                </div>
            @endfor
        </div>

    @elseif ($type === 'list' || $type === 'cards')
        <!-- List / Card Items Skeleton -->
        <div class="divide-y divide-slate-100 dark:divide-slate-800">
            @for ($i = 0; $i < $rows; $i++)
                <div class="flex flex-col gap-3 py-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0 flex-1 space-y-2.5">
                        <div class="flex items-center gap-2">
                            <div class="h-4 w-48 rounded-md skeleton-shimmer"></div>
                            <div class="h-5 w-16 rounded-full skeleton-shimmer"></div>
                        </div>
                        <div class="h-3 w-3/4 max-w-md rounded-md skeleton-shimmer"></div>
                        <div class="h-2.5 w-28 rounded-md skeleton-shimmer"></div>
                    </div>
                    <div class="flex shrink-0 gap-2 pt-1">
                        <div class="h-8 w-16 rounded-lg skeleton-shimmer"></div>
                        <div class="h-8 w-16 rounded-lg skeleton-shimmer"></div>
                    </div>
                </div>
            @endfor
        </div>

    @elseif ($type === 'form')
        <!-- Form Fields Skeleton -->
        <div class="space-y-4">
            <div class="space-y-1.5">
                <div class="h-3 w-20 rounded-md skeleton-shimmer"></div>
                <div class="h-10 w-full rounded-xl skeleton-shimmer"></div>
            </div>
            <div class="space-y-1.5">
                <div class="h-3 w-28 rounded-md skeleton-shimmer"></div>
                <div class="h-20 w-full rounded-xl skeleton-shimmer"></div>
            </div>
            <div class="space-y-1.5">
                <div class="h-3 w-24 rounded-md skeleton-shimmer"></div>
                <div class="h-10 w-full rounded-xl skeleton-shimmer"></div>
            </div>
            <div class="pt-2">
                <div class="h-10 w-full rounded-xl skeleton-shimmer"></div>
            </div>
        </div>

    @else
        <!-- Generic Text / Lines Skeleton -->
        <div class="space-y-3">
            @for ($i = 0; $i < $rows; $i++)
                <div class="flex items-center gap-3">
                    @for ($j = 0; $j < $columns; $j++)
                        <div class="h-4 flex-1 rounded-md skeleton-shimmer"></div>
                    @endfor
                </div>
            @endfor
        </div>
    @endif
</div>
