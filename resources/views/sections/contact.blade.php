@php $config = $section->config ?? []; @endphp

<section class="px-4 py-8 sm:px-6" x-reveal>
    <div class="grid grid-cols-1 gap-8 rounded-[var(--radius-card)] bg-[color:var(--color-ink)] p-8 text-white sm:grid-cols-2 sm:p-12">
        <div>
            <x-ui.badge variant="dark">{{ $config['eyebrow'] ?? 'CONTACT' }}</x-ui.badge>
            <h2 class="mt-6 text-h2 font-semibold">{{ $config['title'] ?? '' }}</h2>
            <p class="mt-4 text-white/70">{{ $config['subtitle'] ?? '' }}</p>

            <div class="mt-8">
                <x-ui.trust-badge :rating="$config['rating'] ?? '4.5'" :review-count="$config['review_count'] ?? '10k avis'" dark />
            </div>
        </div>

        <livewire:contact-form />
    </div>
</section>
