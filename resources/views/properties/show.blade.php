<x-layouts.app
    :meta-title="$property->meta_title ?? $property->title"
    :meta-description="$property->meta_description ?? str($property->description)->limit(155)"
    :og-image="$property->getFirstMediaUrl('gallery') ?: null"
>
    @php
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateListing',
            'name' => $property->title,
            'description' => $property->description,
            'url' => route('properties.show', $property),
            'offers' => [
                '@type' => 'Offer',
                'price' => (float) $property->price,
                'priceCurrency' => 'EUR',
            ],
        ];

        if ($property->city) {
            $structuredData['address'] = [
                '@type' => 'PostalAddress',
                'addressLocality' => $property->city->name,
            ];
        }

        if ($image = $property->getFirstMediaUrl('gallery')) {
            $structuredData['image'] = $image;
        }

        $positionClasses = [
            'top-left' => 'left-6 top-6',
            'top-right' => 'right-16 top-6',
            'bottom-left' => 'bottom-6 left-6',
            'bottom-right' => 'bottom-6 right-6',
            'center' => 'left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2',
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <div class="mx-auto max-w-5xl px-6 py-10 sm:px-12">
        <nav class="mb-6 flex flex-wrap items-center gap-2 text-sm text-[color:var(--color-ink-secondary)]">
            <a href="{{ route('home') }}" class="transition hover:text-[color:var(--color-ink)]">Accueil</a>
            <span>/</span>
            @if ($property->city)
                <span>{{ $property->city->name }}</span>
                <span>/</span>
            @endif
            <span class="text-[color:var(--color-ink)]">{{ $property->title }}</span>
        </nav>

        <div class="relative overflow-hidden rounded-[var(--radius-card)] bg-neutral-100">
            <div class="aspect-[16/9]">
                @if ($property->getFirstMediaUrl('gallery'))
                    <img
                        src="{{ $property->getFirstMediaUrl('gallery') }}"
                        alt="{{ $property->title }}"
                        class="h-full w-full object-cover"
                    >
                @else
                    <div class="flex h-full w-full items-center justify-center text-[color:var(--color-ink-secondary)]">
                        <x-ui.icon name="photo" class="h-12 w-12" />
                    </div>
                @endif
            </div>

            <div class="absolute right-4 top-4">
                <livewire:favorite-button :property="$property" :key="'fav-detail-'.$property->id" />
            </div>

            @if (! empty($property->points_of_interest))
                <div class="pointer-events-none absolute inset-0">
                    @foreach ($property->points_of_interest as $point)
                        <div class="pointer-events-auto absolute {{ $positionClasses[$point['position'] ?? 'top-left'] ?? $positionClasses['top-left'] }}">
                            <x-ui.floating-tag>{{ $point['label'] }}</x-ui.floating-tag>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div>
                <h1 class="text-h2 font-semibold">{{ $property->title }}</h1>
                <p class="mt-1 flex items-center gap-1 text-[color:var(--color-ink-secondary)]">
                    <x-ui.icon name="map-pin" class="h-4 w-4" />
                    {{ $property->address ? $property->address.', ' : '' }}{{ $property->city?->name }}
                </p>
            </div>
            <p class="text-2xl font-semibold">{{ number_format((float) $property->price, 2, ',', ' ') }} €</p>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-6 sm:grid-cols-4">
            <div>
                <p class="text-sm text-[color:var(--color-ink-secondary)]">Transaction</p>
                <p class="font-medium">{{ $property->transaction_type?->label() }}</p>
            </div>
            <div>
                <p class="text-sm text-[color:var(--color-ink-secondary)]">Type</p>
                <p class="font-medium">{{ $property->propertyType?->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-[color:var(--color-ink-secondary)]">Surface</p>
                <p class="font-medium">{{ $property->surface ? $property->surface.' m²' : '—' }}</p>
            </div>
            <div>
                <p class="text-sm text-[color:var(--color-ink-secondary)]">Chambres</p>
                <p class="font-medium">{{ $property->bedrooms ?? '—' }}</p>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-h3 font-semibold">Description</h2>
            <p class="mt-3 whitespace-pre-line text-[color:var(--color-ink-secondary)]">{{ $property->description }}</p>
        </div>

        @if ($property->assignedAgent)
            <div class="mt-8 flex flex-col items-start justify-between gap-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] p-6 sm:flex-row sm:items-center">
                <div>
                    <p class="text-sm text-[color:var(--color-ink-secondary)]">Bien géré par</p>
                    <p class="font-medium">{{ $property->assignedAgent->name }}</p>
                </div>
                <a
                    href="mailto:{{ $property->assignedAgent->email }}"
                    class="rounded-[var(--radius-pill)] bg-[color:var(--color-ink)] px-5 py-2 text-sm text-white transition hover:opacity-90"
                >
                    Contacter
                </a>
            </div>
        @endif

        @if ($similarProperties->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-h3 font-semibold">Biens similaires</h2>
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-3">
                    @foreach ($similarProperties as $similar)
                        <x-ui.property-card :property="$similar" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
