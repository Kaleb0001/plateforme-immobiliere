@props(['label' => null, 'name'])

<div>
    @if ($label)
        <label for="{{ $name }}" class="text-sm">{{ $label }}</label>
    @endif
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full rounded-[var(--radius-field)] border border-[color:var(--color-border)] px-3 py-2']) }}
    >
        {{ $slot }}
    </select>
    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
