<button
    type="button"
    wire:click="toggle"
    class="flex h-8 w-8 items-center justify-center rounded-full bg-white/90 text-[color:var(--color-ink)] transition hover:bg-white"
    aria-label="{{ $isFavorited ? 'Retirer des favoris' : 'Ajouter aux favoris' }}"
>
    <x-ui.icon name="heart" class="h-4 w-4 {{ $isFavorited ? 'fill-current' : '' }}" />
</button>
