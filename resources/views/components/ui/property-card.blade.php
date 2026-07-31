@props(['property'])

<div
    x-data="{ expanded: {{ $property->featured ? 'true' : 'false' }} }"
    class="group h-full overflow-hidden rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] shadow-[var(--shadow-card)] transition duration-300 hover:-translate-y-1 hover:shadow-lg"
>
    <div x-show="!expanded" x-transition.opacity.duration.300ms>
        <div class="relative aspect-[4/3] overflow-hidden bg-neutral-100">
            @if ($property->getFirstMediaUrl('gallery'))
                <img
                    src="{{ $property->getFirstMediaUrl('gallery') }}"
                    alt="{{ $property->title }}"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                >
            @else
                <div class="flex h-full w-full items-center justify-center text-[color:var(--color-ink-secondary)]">
                    <x-ui.icon name="photo" class="h-10 w-10" />
                </div>
            @endif

            <button
                type="button"
                class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-[color:var(--color-ink)] transition hover:bg-white"
                aria-label="Ajouter aux favoris"
            >
                <x-ui.icon name="heart" class="h-4 w-4" />
            </button>
        </div>

        <div class="space-y-2 p-4">
            <div class="flex items-start justify-between gap-2">
                <h3 class="text-h3 font-semibold">{{ $property->title }}</h3>
                <button
                    type="button"
                    @click="expanded = true"
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg border border-[color:var(--color-border)] transition hover:bg-neutral-100"
                    aria-label="Voir la description"
                >
                    <x-ui.icon name="chevron-down" class="h-4 w-4" />
                </button>
            </div>

            <p class="flex items-center gap-1 text-sm text-[color:var(--color-ink-secondary)]">
                <x-ui.icon name="map-pin" class="h-3.5 w-3.5" />
                {{ $property->city?->name }}
            </p>

            <div class="flex items-center justify-between pt-1">
                <span class="text-sm text-[color:var(--color-ink-secondary)]">
                    {{ $property->assignedAgent?->name }}
                </span>
                <span class="font-semibold">{{ number_format((float) $property->price, 2, ',', ' ') }} €</span>
            </div>
        </div>
    </div>

    <div x-show="expanded" x-cloak x-transition.opacity.duration.300ms class="flex h-full min-h-[320px] flex-col justify-between bg-[color:var(--color-ink)] p-5 text-white">
        <div>
            <div class="flex items-start justify-between gap-2">
                <h3 class="text-h3 font-semibold">{{ $property->title }}</h3>
                <button
                    type="button"
                    @click="expanded = false"
                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg border border-white/30 transition hover:bg-white/10"
                    aria-label="Voir la photo"
                >
                    <x-ui.icon name="chevron-down" class="h-4 w-4 -rotate-180" />
                </button>
            </div>

            <p class="mt-1 flex items-center gap-1 text-sm text-white/70">
                <x-ui.icon name="map-pin" class="h-3.5 w-3.5" />
                {{ $property->city?->name }}
            </p>

            <p class="mt-3 text-sm text-white/80">{{ $property->description }}</p>
        </div>

        <p class="pt-4 font-semibold">{{ number_format((float) $property->price, 2, ',', ' ') }} €</p>
    </div>
</div>
