@props(['status' => 'in-stock'])

@php
    $map = [
        'in-stock' => ['badge' => 'badge-success', 'dot' => 'badge-dot-success', 'label' => 'In Stock'],
        'low-stock' => ['badge' => 'badge-warning', 'dot' => 'badge-dot-warning', 'label' => 'Low Stock'],
        'out-of-stock' => ['badge' => 'badge-danger', 'dot' => 'badge-dot-danger', 'label' => 'Out of Stock'],
    ];
    $config = $map[$status] ?? $map['in-stock'];
@endphp

<span {{ $attributes->merge(['class' => "badge {$config['badge']}"]) }}>
    <span class="badge-dot {{ $config['dot'] }}"></span>
    {{ $slot->isEmpty() ? $config['label'] : $slot }}
</span>
