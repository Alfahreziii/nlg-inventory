@props(['variant' => 'success'])

<div data-alert {{ $attributes->merge(['class' => "alert alert-{$variant}"]) }}>
    <span>{{ $slot }}</span>

    <button type="button" data-alert-close class="alert-close" aria-label="Dismiss">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18M6 6l12 12" />
        </svg>
    </button>
</div>
