@props(['title', 'value', 'variant' => 'default', 'tooltip' => null])

@php
    $valueColor = match ($variant) {
        'warning' => 'text-warning-fg dark:text-warning-dark-fg',
        'danger' => 'text-danger-fg dark:text-danger-dark-fg',
        default => 'text-neutral-900 dark:text-neutral-50',
    };
    $iconColor = match ($variant) {
        'warning' => 'text-warning dark:text-warning-dark-dot',
        'danger' => 'text-danger dark:text-danger-dark-dot',
        default => 'text-neutral-400 dark:text-neutral-500',
    };
@endphp

<x-ui.card :title="$tooltip" class="flex items-start justify-between gap-4">
    <div>
        <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">{{ $title }}</p>
        <p class="mt-1 font-display text-2xl font-bold {{ $valueColor }}">{{ $value }}</p>
    </div>

    @isset($icon)
        <div class="shrink-0 {{ $iconColor }}">
            {{ $icon }}
        </div>
    @endisset
</x-ui.card>
