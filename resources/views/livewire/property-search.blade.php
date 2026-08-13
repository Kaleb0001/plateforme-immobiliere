<div class="mx-auto max-w-6xl px-6 py-10 sm:px-12">
    <h1 class="text-h2 font-semibold">Rechercher un bien</h1>

    <div class="mt-6">
        <x-form.input
            name="keyword"
            label="Mot-clé (ville, titre, description...)"
            placeholder="Ex. villa avec vue mer, studio centre-ville..."
            wire:model.live.debounce.400ms="keyword"
        />
    </div>

    <div class="mt-4 grid grid-cols-1 gap-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-6 sm:grid-cols-3 lg:grid-cols-6">
        <div>
            <label class="text-sm font-medium">Transaction</label>
            <div class="mt-1 inline-flex w-full rounded-[var(--radius-pill)] bg-neutral-100 p-1">
                <button
                    type="button"
                    wire:click="$set('transaction', 'location')"
                    class="flex-1 rounded-[var(--radius-pill)] px-3 py-2 text-sm font-medium transition {{ $transaction === 'location' ? 'bg-[color:var(--color-ink)] text-white' : 'text-[color:var(--color-ink-secondary)]' }}"
                >
                    Location
                </button>
                <button
                    type="button"
                    wire:click="$set('transaction', 'vente')"
                    class="flex-1 rounded-[var(--radius-pill)] px-3 py-2 text-sm font-medium transition {{ $transaction === 'vente' ? 'bg-[color:var(--color-ink)] text-white' : 'text-[color:var(--color-ink-secondary)]' }}"
                >
                    Achat
                </button>
            </div>
        </div>

        <x-form.select name="city_id" label="Localisation" wire:model.live="city_id">
            <option value="">Toutes les villes</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </x-form.select>

        <x-form.select name="property_type_id" label="Type" wire:model.live="property_type_id">
            <option value="">Tous les types</option>
            @foreach ($propertyTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </x-form.select>

        <x-form.select name="property_style_id" label="Style" wire:model.live="property_style_id">
            <option value="">Tous les styles</option>
            @foreach ($propertyStyles as $style)
                <option value="{{ $style->id }}">{{ $style->name }}</option>
            @endforeach
        </x-form.select>

        <x-form.input name="price_min" type="number" label="Budget min (€)" wire:model.live.debounce.500ms="price_min" />
        <x-form.input name="price_max" type="number" label="Budget max (€)" wire:model.live.debounce.500ms="price_max" />
    </div>

    <div class="mt-4 flex items-center justify-between">
        <p class="text-sm text-[color:var(--color-ink-secondary)]">{{ $properties->total() }} bien(s) trouvé(s)</p>
        <button type="button" wire:click="resetFilters" class="text-sm underline transition hover:opacity-70">
            Réinitialiser les filtres
        </button>
    </div>

    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-3" wire:loading.class="opacity-50">
        @forelse ($properties as $property)
            <div wire:key="result-{{ $property->id }}">
                <x-ui.property-card :property="$property" />
            </div>
        @empty
            <p class="col-span-full py-12 text-center text-[color:var(--color-ink-secondary)]">
                Aucun bien ne correspond à ces critères pour l'instant.
            </p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $properties->links() }}
    </div>
</div>
