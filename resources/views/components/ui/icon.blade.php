@props(['name'])

@php
$icons = [
    'heart' => ['M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z'],
    'bookmark' => ['M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z'],
    'arrow-up-right' => ['M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25'],
    'map-pin' => [
        'M15 10.5a3 3 0 11-6 0 3 3 0 016 0z',
        'M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z',
    ],
    'photo' => ['M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18'],
    'chevron-down' => ['M19.5 8.25l-7.5 7.5-7.5-7.5'],
    'chevron-left' => ['M15.75 19.5L8.25 12l7.5-7.5'],
    'chevron-right' => ['M8.25 4.5l7.5 7.5-7.5 7.5'],
    'chevron-updown' => ['M8 9l4-4 4 4M8 15l4 4 4-4'],
    'menu' => ['M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5'],
    'x-mark' => ['M6 18L18 6M6 6l12 12'],
    'star' => ['M12 2.5l2.9 6.2 6.6.7-5 4.6 1.4 6.7L12 17.6 6.1 20.7l1.4-6.7-5-4.6 6.6-.7L12 2.5z'],
    'play' => ['M9 7v10l8-5-8-5z'],
    'link' => ['M13.5 10.5l3-3a3.5 3.5 0 10-5-5l-3 3M10.5 13.5l-3 3a3.5 3.5 0 105 5l3-3'],
];

// Icones a contour rectangulaire/rond (reseaux sociaux) : structure differente
// (rect/circle + path), rendues a part plutot que via le tableau path simple.
$socialIcons = [
    'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="5" fill="none" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.5"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/>',
    'linkedin' => '<rect x="3.5" y="3.5" width="17" height="17" rx="3" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M8 10.5v6M8 7.8v.2M12 16.5v-3.7c0-1.3.9-2.3 2.2-2.3s2.3 1 2.3 2.3v3.7" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
    'facebook' => '<path d="M14 8.5h2.5V5H14c-2 0-3.5 1.6-3.5 3.6V11H8v3h2.5v6H13v-6h2.3l.4-3H13V8.9c0-.3.2-.4.4-.4z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>',
];

// Icones pleines (etoile, lecture) plutot qu'au trait : rendu different
// (fill au lieu de stroke) pour un pictogramme lisible en petite taille.
$filled = in_array($name, ['star', 'play']);

$paths = $icons[$name] ?? [];
@endphp

@if (isset($socialIcons[$name]))
    <svg {{ $attributes->merge(['class' => 'h-4 w-4']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        {!! $socialIcons[$name] !!}
    </svg>
@elseif ($filled)
    <svg {{ $attributes->merge(['class' => 'h-4 w-4']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        @foreach ($paths as $d)
            <path d="{{ $d }}" />
        @endforeach
    </svg>
@else
    <svg {{ $attributes->merge(['class' => 'h-4 w-4']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        @foreach ($paths as $d)
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $d }}" />
        @endforeach
    </svg>
@endif
