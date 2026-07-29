@props(['question', 'number' => null])

<div x-data="{ open: false }" class="py-4">
    <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-4 text-left">
        <span class="flex items-baseline gap-3">
            @if ($number)
                <span class="text-xs text-[color:var(--color-ink-secondary)]">{{ $number }}</span>
            @endif
            <span class="font-medium">{{ $question }}</span>
        </span>

        {{-- Le bouton reste toujours borde, que la question soit ouverte ou non. --}}
        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg border border-[color:var(--color-border)]">
            <x-ui.icon
                name="chevron-down"
                class="h-4 w-4 transition-transform duration-300"
                x-bind:class="open ? '-rotate-180' : ''"
            />
        </span>
    </button>
    <div x-show="open" x-collapse class="pl-8 pt-2 text-sm text-[color:var(--color-ink-secondary)]">
        {{ $slot }}
    </div>
</div>
