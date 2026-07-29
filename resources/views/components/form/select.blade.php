@props(['label' => null, 'name'])

<div>
    @if ($label)
        <label for="{{ $name }}" class="text-sm font-medium">{{ $label }}</label>
    @endif
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 w-full rounded-[var(--radius-field)] border-0 bg-neutral-100 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[color:var(--color-ink)]']) }}
    >
        {{ $slot }}
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
