<form wire:submit="send" class="space-y-4 rounded-[var(--radius-card)] bg-white p-6 text-[color:var(--color-ink)]">
    @if ($sent)
        <p class="rounded-[var(--radius-field)] bg-green-50 p-3 text-sm text-green-700">
            Votre message a bien ete envoye, merci !
        </p>
    @endif

    <x-form.input name="name" label="Nom complet" wire:model="name" placeholder="Votre nom..." />
    <x-form.input name="email" type="email" label="Email" wire:model="email" placeholder="Votre email..." />

    <div>
        <label for="contact_message" class="text-sm font-medium">Message</label>
        <textarea
            id="contact_message"
            wire:model="message"
            rows="4"
            placeholder="Comment pouvons-nous vous aider ?"
            class="mt-1 w-full rounded-[var(--radius-field)] border-0 bg-neutral-100 px-3 py-2.5 placeholder:text-[color:var(--color-ink-secondary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-ink)]"
        ></textarea>
        @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <x-form.button class="w-full justify-center">Envoyer</x-form.button>
</form>
