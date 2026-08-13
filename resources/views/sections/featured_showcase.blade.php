@php
$config = $section->config ?? [];
$positionClasses = [
    'top-left' => 'left-6 top-6',
    'top-right' => 'right-6 top-6',
    'bottom-right' => 'bottom-40 right-6',
    'bottom-left' => 'bottom-40 left-6',
    'center' => 'left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2',
];
$properties = $properties ?? collect();
@endphp

<section class="px-4 py-8 sm:px-6" x-reveal>
    @if ($properties->isNotEmpty())
        <div x-data="{ index: 0, count: {{ $properties->count() }} }" class="relative overflow-hidden rounded-[var(--radius-card)] bg-neutral-200">
            <div class="aspect-[16/9]">
                @foreach ($properties as $i => $property)
                    <div x-show="index === {{ $i }}" x-cloak class="absolute inset-0">
                        @if ($property->imageUrl('detail'))
                            <img
                                src="{{ $property->imageUrl('detail') }}"
                                alt="{{ $property->title }}"
                                loading="lazy"
                                decoding="async"
                                class="h-full w-full object-cover"
                            >
                        @endif

                        @if (! empty($property->points_of_interest))
                            <div class="pointer-events-none absolute inset-0">
                                @foreach ($property->points_of_interest as $point)
                                    <div class="pointer-events-auto absolute {{ $positionClasses[$point['position'] ?? 'top-left'] ?? $positionClasses['top-left'] }}">
                                        <x-ui.floating-tag>{{ $point['label'] }}</x-ui.floating-tag>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="absolute bottom-6 left-6 w-[calc(100%-3rem)] max-w-sm rounded-[var(--radius-card)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)]">
                            <h3 class="text-h3 font-semibold">{{ $property->title }}</h3>
                            <p class="mt-1 flex items-center gap-1 text-sm text-[color:var(--color-ink-secondary)]">
                                <x-ui.icon name="map-pin" class="h-3.5 w-3.5" />
                                {{ $property->city?->name }}
                            </p>
                            <p class="mt-2 line-clamp-2 text-sm text-[color:var(--color-ink-secondary)]">{{ $property->description }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex gap-2">
                                    <button
                                        type="button"
                                        @click="index = (index - 1 + count) % count"
                                        class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)] transition hover:bg-[color:var(--color-ink)] hover:text-white disabled:pointer-events-none disabled:opacity-30"
                                        :disabled="count < 2"
                                        aria-label="Bien précédent"
                                    >
                                        <x-ui.icon name="chevron-left" class="h-4 w-4" />
                                    </button>
                                    <button
                                        type="button"
                                        @click="index = (index + 1) % count"
                                        class="flex h-9 w-9 items-center justify-center rounded-full border border-[color:var(--color-border)] transition hover:bg-[color:var(--color-ink)] hover:text-white disabled:pointer-events-none disabled:opacity-30"
                                        :disabled="count < 2"
                                        aria-label="Bien suivant"
                                    >
                                        <x-ui.icon name="chevron-right" class="h-4 w-4" />
                                    </button>
                                </div>
                                <a href="{{ route('properties.show', $property) }}" class="text-lg font-semibold transition hover:opacity-70">
                                    {{ number_format((float) $property->price, 2, ',', ' ') }} €
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
