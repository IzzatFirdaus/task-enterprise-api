@props([
    'title' => config('app.name', 'Enterprise Tasks'),
    'description' => 'Enterprise Tasks keeps personal operational work organized, visible, and moving.',
    'robots' => 'index,follow',
])

<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ request()->url() }}">
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="icon" href="{{ asset('favicon-32x32.svg') }}" type="image/svg+xml" sizes="32x32">
<link rel="icon" href="{{ asset('favicon-192x192.svg') }}" type="image/svg+xml" sizes="192x192">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.svg') }}" sizes="180x180">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<meta name="theme-color" content="#0e7490">
@if (config('app.seo.google_verification'))
    <meta name="google-site-verification" content="{{ config('app.seo.google_verification') }}">
@endif
<title>{{ $title }} | {{ config('app.name', 'Enterprise Tasks') }}</title>