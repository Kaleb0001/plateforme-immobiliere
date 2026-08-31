@props(['rating' => '4.5', 'reviewCount' => '10k avis', 'dark' => false])

{{--
    Bloc de confiance (note + avatars), prevu des le cahier des charges pour
    la section "about" ("bloc de confiance (note + avatars)") mais jamais
    implemente jusqu'ici. Avatars decoratifs (initiales, pas de vraies
    photos - evite de laisser croire a de faux temoignages clients).
--}}

<div class="inline-flex items-center gap-3">
    <div class="flex -space-x-2">
        <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[color:var(--color-surface)] bg-neutral-400 text-[10px] font-semibold text-white">A</span>
        <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[color:var(--color-surface)] bg-neutral-500 text-[10px] font-semibold text-white">M</span>
        <span class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-[color:var(--color-surface)] bg-[color:var(--color-ink)] text-[10px] font-semibold text-white">J</span>
    </div>
    <span class="flex items-center gap-1.5 text-sm {{ $dark ? 'text-white/85' : 'text-[color:var(--color-ink)]' }}">
        <x-ui.icon name="star" class="h-3.5 w-3.5 text-amber-400" />
        <span class="font-medium">{{ $rating }}</span>
        <span class="{{ $dark ? 'text-white/55' : 'text-[color:var(--color-ink-secondary)]' }}">({{ $reviewCount }})</span>
    </span>
</div>
