<x-layouts.app>
    <div class="mx-auto max-w-5xl space-y-16 px-6 py-16">
        <div>
            <h1 class="text-3xl font-semibold">Vitrine des composants (v2)</h1>
            <p class="mt-2 text-[color:var(--color-ink-secondary)]">
                Page de developpement (non destinee au public), revue pour coller de plus pres
                a la structure exacte de la maquette (carte, badges, accordeon, formulaire).
            </p>
        </div>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Cartes de biens</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                @foreach ($properties as $property)
                    <div x-reveal>
                        <x-ui.property-card :property="$property" />
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Cartes de biens (cliquer le chevron pour deplier)</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                @foreach ($properties as $property)
                    <div x-reveal>
                        <x-ui.property-card :property="$property" />
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Carte "mise en avant" (variante description)</h2>
            <div class="max-w-xs">
                <x-ui.property-card :property="$properties->firstWhere('featured', true)" variant="description" />
            </div>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Carte d'introduction (type "Fresh Opportunities")</h2>
            <div class="max-w-xs">
                <x-ui.intro-card title="Nouvelles opportunites">
                    Explorez nos dernieres annonces et trouvez le bien qui vous correspond.
                </x-ui.intro-card>
            </div>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Carrousel</h2>
            <x-ui.carousel>
                @foreach ($properties as $property)
                    <div class="w-72 shrink-0 snap-start">
                        <x-ui.property-card :property="$property" />
                    </div>
                @endforeach
            </x-ui.carousel>
        </section>

        <section class="rounded-[var(--radius-card)] bg-[color:var(--color-ink)] p-10">
            <h2 class="mb-6 text-h2 font-semibold text-white">Badges flottants (sur photo)</h2>
            <div class="flex flex-wrap gap-4">
                <x-ui.floating-tag>Buy Property</x-ui.floating-tag>
                <x-ui.floating-tag dot-position="right">Sell Property</x-ui.floating-tag>
                <x-ui.badge>Balcony 2nd Floor</x-ui.badge>
            </div>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Badges "eyebrow" (etiquettes de section)</h2>
            <div class="flex flex-wrap gap-2">
                <x-ui.badge>ABOUT</x-ui.badge>
                <x-ui.badge>EXPLORE</x-ui.badge>
                <x-ui.badge>POPULAR</x-ui.badge>
            </div>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Accordeon (FAQ)</h2>
            <x-ui.accordion>
                <x-ui.accordion-item number="01" question="Comment fonctionne la plateforme ?">
                    Notre plateforme connecte acheteurs et vendeurs via des outils de recherche intuitifs.
                </x-ui.accordion-item>
                <x-ui.accordion-item number="02" question="Est-ce gratuit ?">
                    Oui, la consultation des biens est entierement gratuite.
                </x-ui.accordion-item>
                <x-ui.accordion-item number="03" question="Comment soumettre un bien ?">
                    Depuis votre espace personnel, une fois connecte.
                </x-ui.accordion-item>
            </x-ui.accordion>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Formulaire</h2>
            <form class="max-w-sm space-y-4">
                <x-form.input name="demo_name" label="Nom" />
                <x-form.select name="demo_city" label="Ville">
                    <option>Selectionner...</option>
                    @foreach ($properties->pluck('city.name')->filter()->unique() as $cityName)
                        <option>{{ $cityName }}</option>
                    @endforeach
                </x-form.select>
                <div class="flex gap-3">
                    <x-form.button>Valider</x-form.button>
                    <x-form.button variant="outline" :icon="false" type="button">Annuler</x-form.button>
                </div>
            </form>
        </section>
    </div>
</x-layouts.app>
