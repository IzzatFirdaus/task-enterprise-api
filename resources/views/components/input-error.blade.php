@props(['messages', 'id' => null])

@if ($messages)
    <ul @if ($id) id="{{ $id }}" @endif {{ $attributes->merge(['class' => 'text-sm font-medium text-rose-600 dark:text-rose-400 space-y-1 mt-1']) }} role="alert">
        @foreach ((array) $messages as $message)
            <li><span aria-hidden="true">!</span> {{ $message }}</li>
        @endforeach
    </ul>
@endif
