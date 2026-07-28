@props(['variant' => 'default'])

@php
$classes = match ($variant) {
    'solid' => 'bg-[color:var(--color-ink)] text-white',
    default => 'border border-[color:var(--color-border)] bg-white/90 text-[color:var(--color-ink)]',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 rounded-[var(--radius-pill)] px-3 py-1 text-sm $classes"]) }}>
    {{ $slot }}
</span>
