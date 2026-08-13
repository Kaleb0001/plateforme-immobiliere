@props(['scrollAmount' => 320])

@php
    // 'full' : utile pour une galerie photo pleine largeur (1 image visible
    // a la fois) ; un nombre fixe : utile pour un bandeau de petites cartes
    // (comportement d'origine, inchange par defaut).
    $amountExpr = $scrollAmount === 'full' ? 'this.$refs.track.clientWidth' : (int) $scrollAmount;
@endphp

<div x-data="{
    scrollByAmount(direction) {
        this.$refs.track.scrollBy({ left: direction * ({{ $amountExpr }}), behavior: 'smooth' });
    }
}" class="relative">
    <div x-ref="track" class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        {{ $slot }}
    </div>

    <div class="mt-4 flex justify-end gap-2">
        <button
            type="button"
            @click="scrollByAmount(-1)"
            class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)] transition hover:bg-[color:var(--color-ink)] hover:text-white"
            aria-label="Précédent"
        >
            <x-ui.icon name="chevron-left" class="h-4 w-4" />
        </button>
        <button
            type="button"
            @click="scrollByAmount(1)"
            class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)] transition hover:bg-[color:var(--color-ink)] hover:text-white"
            aria-label="Suivant"
        >
            <x-ui.icon name="chevron-right" class="h-4 w-4" />
        </button>
    </div>
</div>
