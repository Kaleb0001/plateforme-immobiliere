@props(['hideHeader' => false, 'metaTitle' => null, 'metaDescription' => null, 'ogImage' => null])
@php
$resolvedTitle = $metaTitle ? "{$metaTitle} · " . config('app.name') : config('app.name');
$resolvedDescription = $metaDescription ?? 'Trouvez le bien immobilier qui vous correspond.';

$structuredData = [
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => url('/'),
        ],
        [
            '@type' => 'WebSite',
            'name' => config('app.name'),
            'url' => url('/'),
        ],
    ],
];
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $resolvedTitle }}</title>
    <meta name="description" content="{{ $resolvedDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $resolvedTitle }}">
    <meta property="og:description" content="{{ $resolvedDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $resolvedTitle }}">
    <meta name="twitter:description" content="{{ $resolvedDescription }}">

    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <link rel="preconnect" href="https://api.fontshare.com">
    <link href="https://api.fontshare.com/v2/css?f[]=general-sans@400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased">
    @unless ($hideHeader)
        <header class="sticky top-0 z-50 flex items-center justify-between bg-[color:var(--color-surface)]/95 px-6 py-5 shadow-sm backdrop-blur sm:px-12">
            <a href="{{ route('home') }}" class="text-lg font-bold tracking-wide">{{ config('app.name') }}</a>

            <x-layouts.site-nav :dark="false" />
        </header>
    @endunless

    {{ $slot }}

    @livewireScripts
</body>
</html>
