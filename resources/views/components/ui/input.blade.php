@props(['label' => null, 'name', 'type' => 'text', 'value' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="input-label">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'input-field '.($errors->has($name) ? 'input-field-error' : '')]) }}
    >

    @error($name)
        <p class="input-error-text">{{ $message }}</p>
    @enderror
</div>
