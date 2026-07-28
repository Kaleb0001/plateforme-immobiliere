@props(['question'])

<div x-data="{ open: false }" class="py-4">
    <button type="button" @click="open = !open" class="flex w-full items-center justify-between text-left">
        <span class="font-medium">{{ $question }}</span>
        <svg
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
            class="h-4 w-4 shrink-0 transition-transform duration-300"
            :class="open ? 'rotate-180' : ''"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>
    </button>
    <div x-show="open" x-collapse class="pt-2 text-sm text-[color:var(--color-ink-secondary)]">
        {{ $slot }}
    </div>
</div>
