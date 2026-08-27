@props(['variant' => 'primary', 'type' => 'button'])

@php
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'ghost' => 'btn-ghost',
        'danger' => 'btn-danger',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn {$variantClass}"]) }}>
    {{ $slot }}
</button>
