@props(['variant' => 'solid', 'icon' => true])

@php
$classes = match ($variant) {
    'outline' => 'border border-[color:var(--color-border)] text-[color:var(--color-ink)]',
    default => 'bg-[color:var(--color-ink)] text-white',
};
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center justify-center gap-2 rounded-[var(--radius-pill)] px-4 py-2 font-medium transition hover:opacity-90 $classes"]) }}>
    {{ $slot }}
    @if ($icon)
        <x-ui.icon name="arrow-up-right" class="h-4 w-4" />
    @endif
</button>
