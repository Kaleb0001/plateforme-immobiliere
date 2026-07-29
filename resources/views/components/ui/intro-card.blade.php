@props(['title', 'href' => '#'])

<div class="flex h-full flex-col justify-between rounded-[var(--radius-card)] bg-neutral-100 p-5">
    <div>
        <h3 class="text-h3 font-semibold">{{ $title }}</h3>
        <p class="mt-2 text-sm text-[color:var(--color-ink-secondary)]">{{ $slot }}</p>
    </div>

    <a href="{{ $href }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium">
        Voir plus
        <x-ui.icon name="arrow-up-right" class="h-3.5 w-3.5" />
    </a>
</div>
