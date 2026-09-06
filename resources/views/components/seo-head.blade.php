@props([
    'title' => config('app.name', 'Enterprise Tasks'),
    'description' => 'Enterprise Tasks keeps personal operational work organized, visible, and moving.',
    'robots' => 'index,follow',
    'type' => 'website',
    'image' => null,
    'imageAlt' => null,
    'canonical' => null,
])

@php
    $appName = config('app.name', 'Enterprise Tasks');
    $resolvedImage = $image ?? asset('images/og-default.svg');
    $resolvedImageAlt = $imageAlt ?? $appName.' preview image';
    $resolvedCanonical = $canonical ?? request()->url();
    $fullTitle = str_contains($title, $appName) ? $title : $title.' | '.$appName;
    $ogUrl = $canonical ?? request()->url();
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $resolvedCanonical }}">

<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $ogUrl }}">
<meta property="og:image" content="{{ $resolvedImage }}">
<meta property="og:image:alt" content="{{ $resolvedImageAlt }}">
<meta property="og:site_name" content="{{ $appName }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $resolvedImage }}">
<meta name="twitter:image:alt" content="{{ $resolvedImageAlt }}">

<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<link rel="icon" href="{{ asset('favicon-32x32.svg') }}" type="image/svg+xml" sizes="32x32">
<link rel="icon" href="{{ asset('favicon-192x192.svg') }}" type="image/svg+xml" sizes="192x192">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.svg') }}" sizes="180x180">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
<meta name="theme-color" content="#0e7490">
@if (config('app.seo.google_verification'))
    <meta name="google-site-verification" content="{{ config('app.seo.google_verification') }}">
@endif
