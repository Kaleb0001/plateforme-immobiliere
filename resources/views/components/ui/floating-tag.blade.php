@props(['dotPosition' => 'left'])

<div class="inline-flex items-center gap-2">
    @if ($dotPosition === 'left')
        <span class="h-2 w-2 shrink-0 rounded-full bg-[color:var(--color-ink)]"></span>
    @endif

    <span class="inline-flex items-center rounded-[var(--radius-pill)] border border-white/40 bg-white/90 px-3 py-1.5 text-sm text-[color:var(--color-ink)] shadow-sm backdrop-blur">
        {{ $slot }}
    </span>

    @if ($dotPosition === 'right')
        <span class="h-2 w-2 shrink-0 rounded-full bg-[color:var(--color-ink)]"></span>
    @endif
</div>
