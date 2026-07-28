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
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>
        <button
            type="button"
            @click="scrollByAmount(320)"
            class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)]"
            aria-label="Suivant"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>
</div>
