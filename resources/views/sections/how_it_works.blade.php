@php
$config = $section->config ?? [];
$steps = $config['steps'] ?? [];
@endphp

<section class="grid grid-cols-1 gap-12 px-6 py-24 sm:grid-cols-2 sm:px-12" x-reveal>
    <div>
        <x-ui.badge>{{ $config['eyebrow'] ?? 'COMMENT CA MARCHE' }}</x-ui.badge>
        <h2 class="mt-6 text-h2 font-semibold">{{ $config['title'] ?? 'Comment ca marche ?' }}</h2>

        <div class="mt-8 space-y-8">
            @foreach ($steps as $i => $step)
                <div>
                    <p class="text-sm text-[color:var(--color-ink-secondary)]">{{ sprintf('%02d', $i + 1) }}</p>
                    <h3 class="mt-1 text-lg font-semibold">{{ $step['title'] }}</h3>
                    <p class="mt-1 text-sm text-[color:var(--color-ink-secondary)]">{{ $step['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Apercu decoratif simplifie (pas encore connecte a une vraie recherche) --}}
    <div class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-neutral-50 p-6 shadow-[var(--shadow-card)]">
        <div class="mb-4 flex items-end gap-3">
            <x-form.select name="preview_style" label="Style">
                <option>Tous les styles</option>
            </x-form.select>
            <x-form.button :icon="false" type="button">Rechercher</x-form.button>
        </div>
        <div class="grid grid-cols-2 gap-3">
            @foreach ($previewProperties ?? [] as $property)
                <x-ui.property-card :property="$property" />
            @endforeach
        </div>
    </div>
</section>
