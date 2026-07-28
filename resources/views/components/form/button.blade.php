@props(['variant' => 'solid'])

@php
$classes = match ($variant) {
    'outline' => 'border border-[color:var(--color-border)] text-[color:var(--color-ink)]',
    default => 'bg-[color:var(--color-ink)] text-white',
};
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => "rounded-[var(--radius-pill)] px-4 py-2 font-medium transition hover:opacity-90 $classes"]) }}>
    {{ $slot }}
</button>
