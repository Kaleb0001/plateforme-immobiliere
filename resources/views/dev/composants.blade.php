<x-layouts.app>
    <div class="mx-auto max-w-5xl space-y-16 px-6 py-16">
        <div>
            <h1 class="text-3xl font-semibold">Vitrine des composants</h1>
            <p class="mt-2 text-[color:var(--color-ink-secondary)]">
                Page de developpement (non destinee au public) pour verifier visuellement chaque
                composant reutilisable avant l'assemblage de la vraie page d'accueil (module 6).
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
            <h2 class="mb-6 text-h2 font-semibold">Carrousel</h2>
            <x-ui.carousel>
                @foreach ($properties as $property)
                    <div class="w-72 shrink-0 snap-start">
                        <x-ui.property-card :property="$property" />
                    </div>
                @endforeach
            </x-ui.carousel>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Badges</h2>
            <div class="flex flex-wrap gap-2">
                <x-ui.badge>Vue mer</x-ui.badge>
                <x-ui.badge>Balcon 2e etage</x-ui.badge>
                <x-ui.badge variant="solid">A la une</x-ui.badge>
            </div>
        </section>

        <section>
            <h2 class="mb-6 text-h2 font-semibold">Accordeon (FAQ)</h2>
            <x-ui.accordion>
                <x-ui.accordion-item question="Comment fonctionne la plateforme ?">
                    Notre plateforme connecte acheteurs et vendeurs via des outils de recherche intuitifs.
                </x-ui.accordion-item>
                <x-ui.accordion-item question="Est-ce gratuit ?">
                    Oui, la consultation des biens est entierement gratuite.
                </x-ui.accordion-item>
                <x-ui.accordion-item question="Comment soumettre un bien ?">
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
                    <x-form.button variant="outline" type="button">Annuler</x-form.button>
                </div>
            </form>
        </section>
    </div>
</x-layouts.app>
