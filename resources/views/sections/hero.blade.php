@php
    $config = $section->config ?? [];
    $backgroundUrl = $section->backgroundImageUrl();
@endphp

<section class="relative overflow-hidden">
    <div
        @class([
            'relative mx-4 mt-4 overflow-hidden rounded-[var(--radius-card)] bg-cover bg-center sm:mx-6 sm:mt-6',
            'bg-gradient-to-b from-sky-300 to-sky-100' => ! $backgroundUrl,
        ])
        @style([
            "background-image: linear-gradient(180deg, rgba(0,0,0,.15), rgba(0,0,0,.35)), url('{$backgroundUrl}')" => $backgroundUrl,
        ])
    >
        {{-- Photo de fond geree depuis l'admin (Pages > Accueil > section Hero > Photo de fond).
             A defaut de photo definie, un degrade sert de reserve visuelle. --}}

        <div class="relative px-6 pb-36 pt-8 sm:px-12 sm:pb-44">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-lg font-bold tracking-wide text-white">{{ config('app.name') }}</a>

                <x-layouts.site-nav :dark="true" />
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

            <div class="absolute bottom-28 right-6 z-10 hidden sm:block sm:right-12">
                <x-ui.trust-badge :rating="$config['rating'] ?? '4.5'" :review-count="$config['review_count'] ?? '10k avis'" dark />
            </div>
        </div>
    </div>

    {{-- Widget de recherche : soumission reelle vers la page de resultats
         (route properties.search), en GET pour que la recherche soit partageable
         par URL. --}}
    <form
        method="GET"
        action="{{ route('properties.search') }}"
        x-data="{ tab: 'location' }"
        class="relative z-10 mx-4 -mt-24 rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-6 shadow-[var(--shadow-card)] sm:mx-auto sm:max-w-4xl sm:-mt-20"
    >
        <input type="hidden" name="transaction" :value="tab === 'location' ? 'location' : 'vente'">

        <div class="mb-6 flex rounded-[var(--radius-pill)] bg-neutral-100 p-1 sm:inline-flex">
            <button
                type="button"
                @click="tab = 'location'"
                class="flex-1 rounded-[var(--radius-pill)] px-5 py-2.5 text-sm font-medium transition sm:flex-none sm:py-2"
                :class="tab === 'location' ? 'bg-[color:var(--color-ink)] text-white' : 'text-[color:var(--color-ink-secondary)]'"
            >
                Location
            </button>
            <button
                type="button"
                @click="tab = 'achat'"
                class="flex-1 rounded-[var(--radius-pill)] px-5 py-2.5 text-sm font-medium transition sm:flex-none sm:py-2"
                :class="tab === 'achat' ? 'bg-[color:var(--color-ink)] text-white' : 'text-[color:var(--color-ink-secondary)]'"
            >
                Achat
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-5 sm:items-end">
            <x-form.select name="city_id" label="Localisation">
                <option value="">Toutes les villes</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select name="property_type_id" label="Type">
                <option value="">Tous les types</option>
                @foreach ($propertyTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </x-form.select>

            <x-form.select name="property_style_id" label="Style">
                <option value="">Tous les styles</option>
                @foreach ($propertyStyles as $style)
                    <option value="{{ $style->id }}">{{ $style->name }}</option>
                @endforeach
            </x-form.select>

            <div>
                <label for="price_max" class="text-sm font-medium">Budget max</label>
                <div class="mt-1 flex items-center gap-2 rounded-[var(--radius-field)] bg-neutral-100 px-3 py-2.5">
                    <span class="text-[color:var(--color-ink-secondary)]">€</span>
                    <input
                        type="text"
                        inputmode="numeric"
                        id="price_max"
                        name="price_max"
                        placeholder="200 000"
                        class="w-full min-w-0 border-0 bg-transparent p-0 focus:outline-none focus:ring-0"
                    >
                    <x-ui.icon name="chevron-updown" class="h-4 w-4 shrink-0 text-[color:var(--color-ink-secondary)]" />
                </div>
                @error('price_max')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <x-form.button class="w-full justify-center">Rechercher</x-form.button>
        </div>
    </form>
</section>
