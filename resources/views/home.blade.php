<x-layouts.app :hide-header="true">
    @foreach ($sectionsData as $entry)
        @if ($entry['section']->visible)
            @include('sections.' . $entry['section']->type->value, $entry)
        @endif
    @endforeach
</x-layouts.app>
