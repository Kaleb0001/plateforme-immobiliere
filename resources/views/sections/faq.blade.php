@php $config = $section->config ?? []; @endphp

<section class="px-6 py-24 text-center sm:px-12" x-reveal>
    <div class="flex justify-center">
        <x-ui.badge>{{ $config['eyebrow'] ?? 'FAQ' }}</x-ui.badge>
    </div>
    <h2 class="mt-6 text-h2 font-semibold">{{ $config['title'] ?? 'Questions frequentes' }}</h2>

    <div class="mx-auto mt-10 max-w-2xl text-left">
        <x-ui.accordion>
            @foreach ($items as $i => $item)
                <x-ui.accordion-item :number="sprintf('%02d', $i + 1)" :question="$item->question">
                    {{ $item->answer }}
                </x-ui.accordion-item>
            @endforeach
        </x-ui.accordion>
    </div>
</section>
