@props(['variant' => 'primary', 'type' => 'button', 'href' => null])

@php
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'ghost' => 'btn-ghost',
        'danger' => 'btn-danger',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "btn {$variantClass}"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "btn {$variantClass}"]) }}>
        {{ $slot }}
    </button>
@endif
