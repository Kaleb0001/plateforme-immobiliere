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
        <p
            aria-hidden="true"
            class="select-none whitespace-nowrap px-4 pt-16 text-center font-extrabold uppercase leading-[0.8] tracking-tight text-white/95"
            style="font-size: clamp(3.5rem, 16vw, 11rem);"
        >
            {{ config('app.name') }}
        </p>

        <div class="relative mt-10 flex flex-col gap-6 border-t border-white/15 px-6 py-8 text-sm text-white/80 sm:flex-row sm:items-center sm:justify-between sm:px-12">
            <nav class="flex flex-wrap gap-x-6 gap-y-2">
                @foreach ($config['nav_links'] ?? [] as $link)
                    <a href="{{ $link['href'] ?? '#' }}" class="transition hover:text-white">{{ $link['label'] }}</a>
                @endforeach
            </nav>
            <nav class="flex flex-wrap gap-x-6 gap-y-2">
                @foreach ($config['social_links'] ?? [] as $link)
                    <a href="{{ $link['href'] ?? '#' }}" class="transition hover:text-white">{{ $link['label'] }}</a>
                @endforeach
            </nav>
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
