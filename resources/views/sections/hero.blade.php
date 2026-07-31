@php $config = $section->config ?? []; @endphp

<section class="relative overflow-hidden">
    <div class="relative mx-4 mt-4 overflow-hidden rounded-[var(--radius-card)] bg-gradient-to-b from-sky-300 to-sky-100 sm:mx-6 sm:mt-6">
        {{-- Photo de fond a brancher une fois la mediatheque en place (module 7).
             Le degrade sert de reserve visuelle en attendant. --}}

        <div class="relative px-6 pb-36 pt-8 sm:px-12 sm:pb-44">
            <div class="flex items-center justify-between">
                <span class="text-lg font-bold tracking-wide text-white">VOTRE-MARQUE</span>

                <nav class="hidden items-center gap-6 text-sm text-white/90 lg:flex">
                    <a href="#" class="transition hover:text-white">Vendre un bien</a>
                    <a href="#" class="transition hover:text-white">Acheter un bien</a>
                    <a href="#" class="transition hover:text-white">Louer</a>
                    <a href="#" class="transition hover:text-white">À propos</a>
                    <a href="#" class="transition hover:text-white">Ressources</a>
                </nav>

                @guest
                    <a href="{{ route('login') }}" class="rounded-[var(--radius-pill)] border border-white/50 px-5 py-2 text-sm text-white transition hover:bg-white hover:text-[color:var(--color-ink)]">
                        Connexion
                    </a>
                @endguest
                @auth
                    <a href="{{ route('account') }}" class="rounded-[var(--radius-pill)] border border-white/50 px-5 py-2 text-sm text-white transition hover:bg-white hover:text-[color:var(--color-ink)]">
                        Mon compte
                    </a>
                @endauth
            </div>

            <div class="relative mt-16 max-w-2xl" x-reveal>
                <h1 class="text-hero font-semibold leading-tight text-white">
                    <span>{{ $config['headline_strong_1'] ?? '' }}</span>
                    <span class="text-white/60">{{ $config['headline_light_1'] ?? '' }}</span>
                    <br class="hidden sm:block">
                    <span class="text-white/60">{{ $config['headline_light_2'] ?? '' }}</span>
                    <span>{{ $config['headline_strong_2'] ?? '' }}</span>
                </h1>
                <p class="mt-4 max-w-md text-white/80">{{ $config['subtitle'] ?? '' }}</p>
            </div>

            <div class="mt-10 hidden flex-wrap gap-6 sm:flex">
                <x-ui.floating-tag>{{ $config['tag_1'] ?? 'Acheter un bien' }}</x-ui.floating-tag>
                <x-ui.floating-tag dot-position="right">{{ $config['tag_2'] ?? 'Vendre un bien' }}</x-ui.floating-tag>
            </div>
        </div>
    </div>

    {{-- Widget de recherche : l'interface est fonctionnelle, mais la recherche/filtrage
         reel (page de resultats) arrive au module 10. --}}
    <div class="relative z-10 mx-4 -mt-24 rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-6 shadow-[var(--shadow-card)] sm:mx-auto sm:max-w-4xl sm:-mt-20">
        <div x-data="{ tab: 'location' }" class="mb-6 inline-flex rounded-[var(--radius-pill)] bg-neutral-100 p-1">
            <button
                type="button"
                @click="tab = 'location'"
                class="rounded-[var(--radius-pill)] px-5 py-2 text-sm font-medium transition"
                :class="tab === 'location' ? 'bg-[color:var(--color-ink)] text-white' : 'text-[color:var(--color-ink-secondary)]'"
            >
                Location
            </button>
            <button
                type="button"
                @click="tab = 'achat'"
                class="rounded-[var(--radius-pill)] px-5 py-2 text-sm font-medium transition"
                :class="tab === 'achat' ? 'bg-[color:var(--color-ink)] text-white' : 'text-[color:var(--color-ink-secondary)]'"
            >
                Achat
            </button>
        </div>

        <form class="grid grid-cols-1 gap-4 sm:grid-cols-5 sm:items-end">
            <x-form.select name="location" label="Localisation">
                <option value="">Toutes les villes</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select name="type" label="Type">
                <option value="">Tous les types</option>
                @foreach ($propertyTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select name="style" label="Style">
                <option value="">Tous les styles</option>
                @foreach ($propertyStyles as $style)
                    <option value="{{ $style->id }}">{{ $style->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.input name="price" label="Budget" placeholder="100k - 200k €" />

            <x-form.button type="button" class="w-full justify-center">Rechercher</x-form.button>
        </form>
    </div>
</section>
