<div class="flex min-h-screen items-center justify-center px-6">
    <form wire:submit="login" class="w-full max-w-sm space-y-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-8 shadow-[var(--shadow-card)]">
        <h1 class="text-2xl font-semibold">Se connecter</h1>

        <div>
            <label class="text-sm">Email</label>
            <input type="email" wire:model="email" class="w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2">
            @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm">Mot de passe</label>
            <input type="password" wire:model="password" class="w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2">
            @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" wire:model="remember">
            Se souvenir de moi
        </label>

        <button type="submit" class="w-full rounded-[var(--radius-pill)] bg-[color:var(--color-ink)] px-4 py-2 text-white">
            Se connecter
        </button>

        <p class="text-center text-sm text-[color:var(--color-ink-secondary)]">
            Pas encore de compte ? <a href="{{ route('register') }}" wire:navigate class="underline">Creer un compte</a>
        </p>
    </form>
</div>
