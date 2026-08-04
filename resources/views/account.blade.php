<x-layouts.app :meta-title="'Mon compte'">
    <div class="mx-auto max-w-4xl px-6 py-16">
        <h1 class="text-h2 font-semibold">Bonjour {{ auth()->user()->name }}</h1>
        <p class="mt-2 text-[color:var(--color-ink-secondary)]">Votre espace personnel.</p>

        <div class="mt-8 flex flex-wrap gap-3">
            <a
                href="{{ route('properties.submit') }}"
                class="rounded-[var(--radius-pill)] bg-[color:var(--color-ink)] px-5 py-2 text-sm text-white transition hover:opacity-90"
            >
                Proposer un bien
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="rounded-[var(--radius-pill)] border border-[color:var(--color-border)] px-5 py-2 text-sm transition hover:bg-neutral-100"
                >
                    Se déconnecter
                </button>
            </form>
        </div>

        <section class="mt-12">
            <h2 class="text-h3 font-semibold">Mes favoris</h2>
            @if ($favorites->isEmpty())
                <p class="mt-3 text-sm text-[color:var(--color-ink-secondary)]">Vous n'avez pas encore de favoris.</p>
            @else
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-3">
                    @foreach ($favorites as $property)
                        <x-ui.property-card :property="$property" />
                    @endforeach
                </div>
            @endif
        </section>

        <section class="mt-12">
            <h2 class="text-h3 font-semibold">Mes biens soumis</h2>
            @if ($submissions->isEmpty())
                <p class="mt-3 text-sm text-[color:var(--color-ink-secondary)]">Vous n'avez encore soumis aucun bien.</p>
            @else
                <div class="mt-6 space-y-3">
                    @foreach ($submissions as $property)
                        @php
                            $statusVariant = $property->status === \App\Enums\PropertyStatus::Publie ? 'solid' : 'default';
                        @endphp
                        <div class="flex flex-col gap-2 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-medium">{{ $property->title }}</p>
                                <p class="text-sm text-[color:var(--color-ink-secondary)]">
                                    Soumis le {{ $property->created_at->format('d/m/Y') }}
                                    @if ($property->status === \App\Enums\PropertyStatus::Refuse && $property->rejection_reason)
                                        — Motif : {{ $property->rejection_reason }}
                                    @endif
                                </p>
                            </div>
                            <x-ui.badge :variant="$statusVariant">{{ $property->status->label() }}</x-ui.badge>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
