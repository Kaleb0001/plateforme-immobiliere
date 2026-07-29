<x-layouts.app>
    <div class="mx-auto max-w-2xl px-6 py-16">
        <h1 class="text-2xl font-semibold">Bonjour {{ auth()->user()->name }}</h1>
        <p class="mt-2 text-[color:var(--color-ink-secondary)]">
            Votre espace personnel (favoris, suivi de vos biens soumis) sera construit en détail au module 10,
            une fois le design des pages publiques suivantes en place.
        </p>

        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button type="submit" class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-4 py-2">
                Se déconnecter
            </button>
        </form>
    </div>
</x-layouts.app>
