@props(['dark' => false])

{{--
    Navigation partagee (liens + CTA connexion + menu mobile plein ecran).
    Un seul endroit a modifier pour les liens du site, utilise par :
    - le header du hero (photo de fond, "dark" = texte blanc)
    - le header flottant qui apparait au scroll sur l'accueil
    - le header générique des autres pages (compte, recherche, fiche bien...)

    Avant ce composant, ces 3 endroits dupliquaient le meme markup et
    n'affichaient aucune navigation sur mobile (liens caches en `lg:flex`
    sans alternative). Le bouton hamburger + panneau plein ecran ci-dessous
    comble ce manque sur toutes les tailles d'ecran.
--}}

<div x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false" class="flex items-center gap-3">
    <nav class="hidden items-center gap-6 text-sm lg:flex {{ $dark ? 'text-white/90' : 'text-[color:var(--color-ink-secondary)]' }}">
        <a href="{{ route('register') }}" class="transition {{ $dark ? 'hover:text-white' : 'hover:text-[color:var(--color-ink)]' }}">Vendre un bien</a>
        <a href="{{ route('properties.search', ['transaction' => 'vente']) }}" class="transition {{ $dark ? 'hover:text-white' : 'hover:text-[color:var(--color-ink)]' }}">Acheter un bien</a>
        <a href="{{ route('properties.search', ['transaction' => 'location']) }}" class="transition {{ $dark ? 'hover:text-white' : 'hover:text-[color:var(--color-ink)]' }}">Louer</a>
        <a href="{{ route('about') }}" class="transition {{ $dark ? 'hover:text-white' : 'hover:text-[color:var(--color-ink)]' }}">À propos</a>
        <a href="#" class="transition {{ $dark ? 'hover:text-white' : 'hover:text-[color:var(--color-ink)]' }}">Ressources</a>
    </nav>

    @guest
        @unless (request()->routeIs('login'))
            <a
                href="{{ route('login') }}"
                class="hidden rounded-[var(--radius-pill)] border px-5 py-2 text-sm transition sm:inline-flex {{ $dark ? 'border-white/50 text-white hover:bg-white hover:text-[color:var(--color-ink)]' : 'border-[color:var(--color-border)] hover:bg-[color:var(--color-ink)] hover:text-white' }}"
            >
                Connexion
            </a>
        @endunless
    @endguest
    @auth
        <a
            href="{{ route('account') }}"
            class="hidden rounded-[var(--radius-pill)] border px-5 py-2 text-sm transition sm:inline-flex {{ $dark ? 'border-white/50 text-white hover:bg-white hover:text-[color:var(--color-ink)]' : 'border-[color:var(--color-border)] hover:bg-[color:var(--color-ink)] hover:text-white' }}"
        >
            Mon compte
        </a>
    @endauth

    <button
        type="button"
        @click="mobileOpen = true"
        class="flex h-10 w-10 items-center justify-center rounded-full border transition lg:hidden {{ $dark ? 'border-white/50 text-white hover:bg-white/10' : 'border-[color:var(--color-border)] hover:bg-neutral-100' }}"
        aria-label="Ouvrir le menu"
        aria-haspopup="true"
        :aria-expanded="mobileOpen"
    >
        <x-ui.icon name="menu" class="h-5 w-5" />
    </button>

    {{-- Menu mobile plein ecran --}}
    <div
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[60] bg-[color:var(--color-surface)] lg:hidden"
        role="dialog"
        aria-modal="true"
    >
        <div class="flex items-center justify-between px-6 py-5 sm:px-12">
            <a href="{{ route('home') }}" @click="mobileOpen = false" class="text-lg font-bold tracking-wide">{{ config('app.name') }}</a>
            <button
                type="button"
                @click="mobileOpen = false"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-[color:var(--color-border)] transition hover:bg-neutral-100"
                aria-label="Fermer le menu"
            >
                <x-ui.icon name="x-mark" class="h-5 w-5" />
            </button>
        </div>

        <nav class="flex flex-col gap-1 px-6 py-6 sm:px-12">
            <a @click="mobileOpen = false" href="{{ route('register') }}" class="border-b border-[color:var(--color-border)] py-4 text-2xl font-semibold transition hover:text-[color:var(--color-ink-secondary)]">Vendre un bien</a>
            <a @click="mobileOpen = false" href="{{ route('properties.search', ['transaction' => 'vente']) }}" class="border-b border-[color:var(--color-border)] py-4 text-2xl font-semibold transition hover:text-[color:var(--color-ink-secondary)]">Acheter un bien</a>
            <a @click="mobileOpen = false" href="{{ route('properties.search', ['transaction' => 'location']) }}" class="border-b border-[color:var(--color-border)] py-4 text-2xl font-semibold transition hover:text-[color:var(--color-ink-secondary)]">Louer</a>
            <a @click="mobileOpen = false" href="{{ route('about') }}" class="border-b border-[color:var(--color-border)] py-4 text-2xl font-semibold transition hover:text-[color:var(--color-ink-secondary)]">À propos</a>
            <a @click="mobileOpen = false" href="#" class="border-b border-[color:var(--color-border)] py-4 text-2xl font-semibold transition hover:text-[color:var(--color-ink-secondary)]">Ressources</a>
        </nav>

        <div class="px-6 sm:px-12">
            @guest
                <a
                    href="{{ route('login') }}"
                    @click="mobileOpen = false"
                    class="inline-flex w-full items-center justify-center rounded-[var(--radius-pill)] bg-[color:var(--color-ink)] px-5 py-3 text-sm font-medium text-white transition hover:opacity-90"
                >
                    Connexion
                </a>
            @endguest
            @auth
                <a
                    href="{{ route('account') }}"
                    @click="mobileOpen = false"
                    class="inline-flex w-full items-center justify-center rounded-[var(--radius-pill)] bg-[color:var(--color-ink)] px-5 py-3 text-sm font-medium text-white transition hover:opacity-90"
                >
                    Mon compte
                </a>
            @endauth
        </div>
    </div>
</div>
