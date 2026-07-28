@props(['label' => null, 'name', 'type' => 'text'])

<div>
    @if ($label)
        <label for="{{ $name }}" class="text-sm">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2']) }}
    >
    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
