@props(['label' => null, 'name', 'value' => null, 'rows' => 4])

<div>
    @if ($label)
        <label for="{{ $name }}" class="input-label">{{ $label }}</label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'input-field '.($errors->has($name) ? 'input-field-error' : '')]) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="input-error-text">{{ $message }}</p>
    @enderror
</div>
