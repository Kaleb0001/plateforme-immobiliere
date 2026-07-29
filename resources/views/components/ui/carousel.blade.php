@props([])

<div x-data="{
    scrollByAmount(amount) {
        this.$refs.track.scrollBy({ left: amount, behavior: 'smooth' });
    }
}" class="relative">
    <div x-ref="track" class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        {{ $slot }}
    </div>

    <div class="mt-4 flex justify-end gap-2">
        <button
            type="button"
            @click="scrollByAmount(-320)"
            class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)]"
            aria-label="Precedent"
        >
            <x-ui.icon name="chevron-left" class="h-4 w-4" />
        </button>
        <button
            type="button"
            @click="scrollByAmount(320)"
            class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)]"
            aria-label="Suivant"
        >
            <x-ui.icon name="chevron-right" class="h-4 w-4" />
        </button>
    </div>
</div>
