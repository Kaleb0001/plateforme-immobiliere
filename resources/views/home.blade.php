<x-layouts.app
    :hide-header="true"
    :meta-title="$page->meta_title"
    :meta-description="$page->meta_description"
    :og-image="$ogImage ?? null"
>
    <div
        x-data="{ show: false }"
        x-init="window.addEventListener('scroll', () => { show = window.scrollY > 420 })"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed inset-x-0 top-0 z-50 flex items-center justify-between bg-[color:var(--color-surface)]/95 px-6 py-4 shadow-sm backdrop-blur sm:px-12"
        style="display: none;"
    >
        <a href="{{ route('home') }}" class="text-lg font-bold tracking-wide">{{ config('app.name') }}</a>

        <x-layouts.site-nav :dark="false" />
    </div>

    @foreach ($sectionsData as $entry)
        @if ($entry['section']->visible)
            @include('sections.' . $entry['section']->type->value, $entry)
        @endif
    @endforeach
</x-layouts.app>
