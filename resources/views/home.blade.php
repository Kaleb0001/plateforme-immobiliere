<x-layouts.app
    :hide-header="true"
    :meta-title="$page->meta_title"
    :meta-description="$page->meta_description"
    :og-image="$ogImage ?? null"
>
    <div
        x-data="{ show: false }"
        x-init="window.addEventListener('scroll', () => { show = window.scrollY > 420 })"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed inset-x-0 top-0 z-50 flex items-center justify-between bg-[color:var(--color-surface)]/95 px-6 py-4 shadow-sm backdrop-blur sm:px-12"
        style="display: none;"
    >
        <a href="{{ route('home') }}" class="text-lg font-bold tracking-wide">VOTRE-MARQUE</a>

        <nav class="hidden items-center gap-6 text-sm text-[color:var(--color-ink-secondary)] lg:flex">
            <a href="{{ route('register') }}" class="transition hover:text-[color:var(--color-ink)]">Vendre un bien</a>
            <a href="{{ route('properties.search', ['transaction' => 'vente']) }}" class="transition hover:text-[color:var(--color-ink)]">Acheter un bien</a>
            <a href="{{ route('properties.search', ['transaction' => 'location']) }}" class="transition hover:text-[color:var(--color-ink)]">Louer</a>
            <a href="{{ route('about') }}" class="transition hover:text-[color:var(--color-ink)]">À propos</a>
            <a href="#" class="transition hover:text-[color:var(--color-ink)]">Ressources</a>
        </nav>

        @guest
            <a href="{{ route('login') }}" class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-5 py-2 text-sm transition hover:bg-[color:var(--color-ink)] hover:text-white">
                Connexion
            </a>
        @endguest
        @auth
            <a href="{{ route('account') }}" class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-5 py-2 text-sm transition hover:bg-[color:var(--color-ink)] hover:text-white">
                Mon compte
            </a>
        @endauth
    </div>

    @foreach ($sectionsData as $entry)
        @if ($entry['section']->visible)
            @include('sections.' . $entry['section']->type->value, $entry)
        @endif
    @endforeach
</x-layouts.app>
