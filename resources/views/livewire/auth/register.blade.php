<div class="flex min-h-screen items-center justify-center px-6">
    <form wire:submit="register" class="w-full max-w-sm space-y-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-8 shadow-[var(--shadow-card)]">
        <h1 class="text-2xl font-semibold">Creer un compte</h1>

        <div>
            <label class="text-sm">Nom</label>
            <input type="text" wire:model="name" class="w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2">
            @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm">Email</label>
            <input type="email" wire:model="email" class="w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2">
            @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm">Telephone (optionnel)</label>
            <input type="text" wire:model="phone" class="w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2">
        </div>

        <div>
            <label class="text-sm">Mot de passe</label>
            <input type="password" wire:model="password" class="w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2">
            @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm">Confirmer le mot de passe</label>
            <input type="password" wire:model="password_confirmation" class="w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2">
        </div>

        <button type="submit" class="w-full rounded-[var(--radius-pill)] bg-[color:var(--color-ink)] px-4 py-2 text-white">
            Creer mon compte
        </button>

        <p class="text-center text-sm text-[color:var(--color-ink-secondary)]">
            Deja un compte ? <a href="{{ route('login') }}" wire:navigate class="underline">Se connecter</a>
        </p>
    </form>
</div>
