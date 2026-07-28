@props(['property'])

<div class="group overflow-hidden rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] shadow-[var(--shadow-card)]">
    <div class="relative aspect-[4/3] overflow-hidden bg-neutral-100">
        @if ($property->getFirstMediaUrl('gallery'))
            <img
                src="{{ $property->getFirstMediaUrl('gallery') }}"
                alt="{{ $property->title }}"
                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
            >
        @else
            <div class="flex h-full w-full items-center justify-center text-[color:var(--color-ink-secondary)]">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-10 w-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18" />
                </svg>
            </div>
        @endif

        <button
            type="button"
            class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-[color:var(--color-ink)]"
            aria-label="Ajouter aux favoris"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>
        </button>
    </div>

    <div class="space-y-1 p-4">
        <h3 class="text-h3 font-semibold">{{ $property->title }}</h3>
        <p class="text-sm text-[color:var(--color-ink-secondary)]">{{ $property->city?->name }}</p>

        @if ($property->featured && $property->description)
            <p class="line-clamp-3 text-sm text-[color:var(--color-ink-secondary)]">{{ $property->description }}</p>
        @endif

        <p class="pt-2 font-semibold">{{ number_format((float) $property->price, 2, ',', ' ') }} €</p>
    </div>
</div>
