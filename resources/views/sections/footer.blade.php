@php
    $config = $section->config ?? [];
    $backgroundUrl = $section->backgroundImageUrl();
@endphp

<footer class="mt-16">
    {{-- Grand moment de marque avant le footer utilitaire, fidèle à la maquette :
         photo (optionnelle) + wordmark géant. Un fond sombre uni sert de
         réserve visuelle tant qu'aucune photo n'est définie depuis l'admin. --}}
    <div
        @class([
            'relative mx-4 overflow-hidden rounded-[var(--radius-card)] bg-cover bg-center sm:mx-6',
            'bg-[color:var(--color-ink)]' => ! $backgroundUrl,
        ])
        @style([
            "background-image: linear-gradient(0deg, rgba(0,0,0,.55), rgba(0,0,0,.25)), url('{$backgroundUrl}')" => $backgroundUrl,
        ])
    >
        <div class="absolute left-6 top-6 z-10 sm:left-12">
            <x-ui.floating-tag>{{ $config['tag_1'] ?? 'Louer un bien' }}</x-ui.floating-tag>
        </div>

        <p
            aria-hidden="true"
            class="select-none whitespace-nowrap px-4 pb-10 pt-16 text-center font-extrabold uppercase leading-[0.8] tracking-tight text-white/95"
            style="font-size: clamp(3.5rem, 16vw, 11rem);"
        >
            {{ config('app.name') }}
        </p>
    </div>

    {{-- Barre de navigation utilitaire : fond blanc, separee du bloc photo
         (elle etait auparavant surimposee en blanc sur la photo - corrige
         pour correspondre a la maquette de reference). --}}
    <div class="flex flex-col gap-6 px-6 py-8 text-sm sm:flex-row sm:items-center sm:justify-between sm:px-12">
        <nav class="flex flex-wrap gap-x-6 gap-y-2 text-[color:var(--color-ink-secondary)]">
            @foreach ($config['nav_links'] ?? [] as $link)
                <a href="{{ $link['href'] ?? '#' }}" class="transition hover:text-[color:var(--color-ink)]">{{ $link['label'] }}</a>
            @endforeach
        </nav>
        <div class="flex gap-3">
            @foreach ($config['social_links'] ?? [] as $link)
                <a
                    href="{{ $link['href'] ?? '#' }}"
                    class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)] text-[color:var(--color-ink-secondary)] transition hover:bg-[color:var(--color-ink)] hover:text-white"
                    aria-label="{{ $link['label'] }}"
                >
                    <x-ui.icon name="{{ in_array(strtolower($link['label'] ?? ''), ['instagram', 'linkedin', 'facebook']) ? strtolower($link['label']) : 'link' }}" class="h-3.5 w-3.5" />
                </a>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col justify-between gap-4 px-6 py-6 text-sm text-[color:var(--color-ink-secondary)] sm:flex-row sm:px-12">
        <span>&copy; {{ now()->year }} {{ config('app.name') }}. Tous droits réservés.</span>
        <div class="flex gap-4">
            <a href="#" class="transition hover:text-[color:var(--color-ink)]">Politique de confidentialité</a>
            <a href="#" class="transition hover:text-[color:var(--color-ink)]">Conditions d'utilisation</a>
        </div>
    </div>
</footer>
