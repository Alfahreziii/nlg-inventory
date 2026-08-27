<div id="delete-modal" data-modal class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop" data-modal-close></div>

    <div class="relative z-50 flex min-h-full items-start justify-center p-4 sm:items-center">
        <div class="modal-panel">
            <div class="flex items-center justify-between border-b border-neutral-200 px-6 py-4 dark:border-neutral-800">
                <h2 class="font-display text-lg font-semibold">Delete Product?</h2>
                <button type="button" data-modal-close class="topbar-icon-btn" aria-label="Close">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 py-4">
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Are you sure you want to delete
                    <span data-modal-name class="font-medium text-neutral-900 dark:text-neutral-50"></span>?
                    This action cannot be undone.
                </p>
            </div>

            <form method="POST" action="" class="flex items-center justify-end gap-3 border-t border-neutral-200 px-6 py-4 dark:border-neutral-800">
                @csrf
                @method('DELETE')
                <button type="button" data-modal-close class="btn btn-ghost">Cancel</button>
                <x-ui.button type="submit" variant="danger">Delete</x-ui.button>
            </form>
        </div>
    </div>
</div>
