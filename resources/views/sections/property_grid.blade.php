@php $config = $section->config ?? []; @endphp

<section class="px-6 py-16 sm:px-12" x-reveal>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <x-ui.badge>{{ $config['eyebrow'] ?? '' }}</x-ui.badge>
            <h2 class="mt-4 text-h2 font-semibold">{{ $config['title'] ?? '' }}</h2>
        </div>
    </div>

    <x-ui.carousel>
        @if ($config['show_intro_card'] ?? false)
            <div class="w-64 shrink-0 snap-start">
                <x-ui.intro-card :title="$config['intro_title'] ?? ''">
                    {{ $config['intro_text'] ?? '' }}
                </x-ui.intro-card>
            </div>
        @endif

        @foreach ($properties as $property)
            <div class="w-72 shrink-0 snap-start">
                <x-ui.property-card :property="$property" />
            </div>
        @endforeach
    </x-ui.carousel>
</section>
