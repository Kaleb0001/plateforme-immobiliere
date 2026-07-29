@props(['label' => null, 'name', 'type' => 'text'])

<div>
    @if ($label)
        <label for="{{ $name }}" class="text-sm font-medium">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 w-full rounded-[var(--radius-field)] border-0 bg-neutral-100 px-3 py-2.5 placeholder:text-[color:var(--color-ink-secondary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-ink)]']) }}
    >
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
