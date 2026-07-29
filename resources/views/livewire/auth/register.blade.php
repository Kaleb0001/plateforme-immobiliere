<div class="flex min-h-screen items-center justify-center px-6">
    <form wire:submit="register" class="w-full max-w-sm space-y-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-8 shadow-[var(--shadow-card)]">
        <h1 class="text-2xl font-semibold">Creer un compte</h1>

        <x-form.input name="name" label="Nom" wire:model="name" />
        <x-form.input name="email" type="email" label="Email" wire:model="email" />
        <x-form.input name="phone" label="Telephone (optionnel)" wire:model="phone" />
        <x-form.input name="password" type="password" label="Mot de passe" wire:model="password" />
        <x-form.input name="password_confirmation" type="password" label="Confirmer le mot de passe" wire:model="password_confirmation" />

        <x-form.button class="w-full">Creer mon compte</x-form.button>

        <p class="text-center text-sm text-[color:var(--color-ink-secondary)]">
            Deja un compte ? <a href="{{ route('login') }}" class="underline">Se connecter</a>
        </p>
    </form>
</div>
