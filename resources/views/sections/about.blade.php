@php $config = $section->config ?? []; @endphp

<section class="px-6 py-24 text-center sm:px-12" x-reveal>
    <div class="flex justify-center">
        <x-ui.badge>{{ $config['eyebrow'] ?? 'A PROPOS' }}</x-ui.badge>
    </div>

    <p class="mx-auto mt-6 max-w-2xl text-2xl leading-relaxed">
        <span class="font-semibold">{{ $config['strong_text'] ?? '' }}</span>
        <span class="text-[color:var(--color-ink-secondary)]">{{ $config['light_text'] ?? '' }}</span>
    </p>
</section>
