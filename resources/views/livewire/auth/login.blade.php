<div class="flex min-h-screen items-center justify-center px-6">
    <form wire:submit="login" class="w-full max-w-sm space-y-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-8 shadow-[var(--shadow-card)]">
        <h1 class="text-2xl font-semibold">Se connecter</h1>

        <x-form.input name="email" type="email" label="Email" wire:model="email" />
        <x-form.input name="password" type="password" label="Mot de passe" wire:model="password" />

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" wire:model="remember">
            Se souvenir de moi
        </label>

        <x-form.button class="w-full">Se connecter</x-form.button>

        <p class="text-center text-sm text-[color:var(--color-ink-secondary)]">
            Pas encore de compte ? <a href="{{ route('register') }}" class="underline">Creer un compte</a>
        </p>
    </form>
</div>
