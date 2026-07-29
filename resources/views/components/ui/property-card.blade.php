@props(['property', 'variant' => 'default'])

@php
$isDescription = $variant === 'description' || ($property->featured && $property->description);
@endphp

<div class="h-full overflow-hidden rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] shadow-[var(--shadow-card)]">
    @if ($isDescription)
        {{-- Variante "mise en avant" (ex. Happy Lagoon Farm dans la maquette) :
             fond sombre, description, sans photo. --}}
        <div class="relative flex h-full min-h-[320px] flex-col justify-between bg-[color:var(--color-ink)] p-5 text-white">
            <button
                type="button"
                class="absolute right-4 top-4 flex h-8 w-8 items-center justify-center rounded-lg border border-white/30"
                aria-label="Sauvegarder"
            >
                <x-ui.icon name="bookmark" class="h-4 w-4" />
            </button>

            <div>
                <h3 class="text-h3 font-semibold">{{ $property->title }}</h3>
                <p class="mt-1 flex items-center gap-1 text-sm text-white/70">
                    <x-ui.icon name="map-pin" class="h-3.5 w-3.5" />
                    {{ $property->city?->name }}
                </p>
                <p class="mt-3 text-sm text-white/80">{{ Str::limit($property->description, 160) }}</p>
            </div>

            <p class="pt-4 text-lg font-semibold">{{ number_format((float) $property->price, 2, ',', ' ') }} €</p>
        </div>
    @else
        <div class="relative aspect-[4/3] overflow-hidden bg-neutral-100">
            @if ($property->getFirstMediaUrl('gallery'))
                <img
                    src="{{ $property->getFirstMediaUrl('gallery') }}"
                    alt="{{ $property->title }}"
                    class="h-full w-full object-cover"
                >
            @else
                <div class="flex h-full w-full items-center justify-center text-[color:var(--color-ink-secondary)]">
                    <x-ui.icon name="photo" class="h-10 w-10" />
                </div>
            @endif

            <button
                type="button"
                class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-[color:var(--color-ink)]"
                aria-label="Ajouter aux favoris"
            >
                <x-ui.icon name="heart" class="h-4 w-4" />
            </button>
        </div>

        <div class="space-y-2 p-4">
            <div class="flex items-start justify-between gap-2">
                <h3 class="text-h3 font-semibold">{{ $property->title }}</h3>
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg border border-[color:var(--color-border)]">
                    <x-ui.icon name="arrow-up-right" class="h-3.5 w-3.5" />
                </span>
            </div>

            <p class="flex items-center gap-1 text-sm text-[color:var(--color-ink-secondary)]">
                <x-ui.icon name="map-pin" class="h-3.5 w-3.5" />
                {{ $property->city?->name }}
            </p>

            <div class="flex items-center justify-between pt-1">
                {{-- L'agent assigne peut s'afficher ici (nom seulement, voir remarque
                     dans le README a propos des avis/notes vus sur la maquette). --}}
                <span class="text-sm text-[color:var(--color-ink-secondary)]">
                    {{ $property->assignedAgent?->name }}
                </span>
                <span class="font-semibold">{{ number_format((float) $property->price, 2, ',', ' ') }} €</span>
            </div>
        </div>
    @endif
</div>
