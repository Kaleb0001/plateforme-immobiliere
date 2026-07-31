@php $config = $section->config ?? []; @endphp

<footer class="mt-16 border-t border-[color:var(--color-border)] px-6 py-12 sm:px-12">
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
        <nav class="flex flex-col gap-3 text-sm">
            @foreach ($config['nav_links'] ?? [] as $link)
                <a href="{{ $link['href'] ?? '#' }}" class="w-fit transition hover:text-[color:var(--color-ink-secondary)]">{{ $link['label'] }}</a>
            @endforeach
        </nav>
        <nav class="flex flex-col gap-3 text-sm sm:items-end">
            @foreach ($config['social_links'] ?? [] as $link)
                <a href="{{ $link['href'] ?? '#' }}" class="w-fit transition hover:text-[color:var(--color-ink-secondary)]">{{ $link['label'] }}</a>
            @endforeach
        </nav>
    </div>

    <div class="mt-10 flex flex-col justify-between gap-4 border-t border-[color:var(--color-border)] pt-6 text-sm text-[color:var(--color-ink-secondary)] sm:flex-row">
        <span>&copy; {{ now()->year }} VOTRE-MARQUE. Tous droits réservés.</span>
        <div class="flex gap-4">
            <a href="#" class="transition hover:text-[color:var(--color-ink)]">Politique de confidentialité</a>
            <a href="#" class="transition hover:text-[color:var(--color-ink)]">Conditions d'utilisation</a>
        </div>
    </div>
</footer>
