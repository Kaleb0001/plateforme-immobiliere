<x-layouts.app
    :meta-title="'À propos'"
    :meta-description="'En savoir plus sur VOTRE-MARQUE.'"
>
    {{--
        Page structurelle : le texte ci-dessous est un point de depart a
        remplacer par votre vraie histoire, mission et differenciateurs des
        que vous les aurez definis - je n'invente pas de faits vous concernant
        (annees d'existence, effectifs, chiffres...).
    --}}
    <div class="mx-auto max-w-3xl px-6 py-16 text-center" x-reveal>
        <div class="flex justify-center">
            <x-ui.badge>À PROPOS</x-ui.badge>
        </div>
        <h1 class="mt-6 text-h2 font-semibold">Notre mission</h1>
        <p class="mt-4 text-lg text-[color:var(--color-ink-secondary)]">
            [À compléter] Présentez ici votre histoire, votre mission et ce qui vous distingue dans
            l'accompagnement de vos clients acheteurs, vendeurs et locataires.
        </p>
    </div>

    <div class="mx-auto grid max-w-4xl grid-cols-1 gap-6 px-6 pb-16 sm:grid-cols-3">
        <div class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-6 text-center">
            <h3 class="font-semibold">Confiance</h3>
            <p class="mt-2 text-sm text-[color:var(--color-ink-secondary)]">[À compléter]</p>
        </div>
        <div class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-6 text-center">
            <h3 class="font-semibold">Accompagnement</h3>
            <p class="mt-2 text-sm text-[color:var(--color-ink-secondary)]">[À compléter]</p>
        </div>
        <div class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-6 text-center">
            <h3 class="font-semibold">Transparence</h3>
            <p class="mt-2 text-sm text-[color:var(--color-ink-secondary)]">[À compléter]</p>
        </div>
    </div>

    <div class="border-t border-[color:var(--color-border)] px-6 py-16 text-center">
        <h2 class="text-h3 font-semibold">Prêt à trouver votre bien ?</h2>
        <a
            href="{{ route('properties.search') }}"
            class="mt-6 inline-flex rounded-[var(--radius-pill)] bg-[color:var(--color-ink)] px-6 py-3 text-white transition hover:opacity-90"
        >
            Commencer la recherche
        </a>
    </div>
</x-layouts.app>
