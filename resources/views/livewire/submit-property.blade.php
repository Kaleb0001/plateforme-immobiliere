<div class="mx-auto max-w-2xl px-6 py-16">
    <h1 class="text-h2 font-semibold">Proposer un bien</h1>
    <p class="mt-2 text-[color:var(--color-ink-secondary)]">
        Ce formulaire simplifié suffit pour démarrer — un membre de notre équipe complètera et validera votre
        annonce avant publication.
    </p>

    @if ($submitted)
        <div class="mt-6 rounded-[var(--radius-field)] bg-green-50 p-4 text-sm text-green-700">
            Votre bien a été soumis et est en attente de validation. Vous pouvez suivre son statut depuis
            <a href="{{ route('account') }}" class="underline">votre espace personnel</a>.
        </div>
    @endif

    <form wire:submit="submit" class="mt-8 space-y-4">
        <x-form.input name="title" label="Titre du bien" wire:model="title" />

        <div>
            <label for="submission_description" class="text-sm font-medium">Description</label>
            <textarea
                id="submission_description"
                wire:model="description"
                rows="4"
                class="mt-1 w-full rounded-[var(--radius-field)] border-0 bg-neutral-100 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[color:var(--color-ink)]"
            ></textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="submission_transaction" class="text-sm font-medium">Transaction</label>
                <select
                    id="submission_transaction"
                    wire:model="transaction_type"
                    class="mt-1 w-full rounded-[var(--radius-field)] border-0 bg-neutral-100 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[color:var(--color-ink)]"
                >
                    <option value="vente">Vente</option>
                    <option value="location">Location</option>
                </select>
            </div>
            <x-form.input name="price" type="number" label="Prix (€)" wire:model="price" />
        </div>

        <x-form.select name="city_id" label="Ville" wire:model="city_id">
            <option value="">Sélectionner...</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </x-form.select>

        <x-form.select name="property_type_id" label="Type de bien" wire:model="property_type_id">
            <option value="">Sélectionner...</option>
            @foreach ($propertyTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </x-form.select>

        <div>
            <label for="submission_photos" class="text-sm font-medium">Photos (optionnel)</label>
            <input
                type="file"
                id="submission_photos"
                wire:model="photos"
                multiple
                class="mt-1 w-full rounded-[var(--radius-field)] bg-neutral-100 px-3 py-2.5 text-sm"
            >
            @error('photos.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            <p wire:loading wire:target="photos" class="mt-1 text-sm text-[color:var(--color-ink-secondary)]">Envoi des photos...</p>
        </div>

        <x-form.button class="w-full justify-center">Soumettre mon bien</x-form.button>
    </form>
</div>
