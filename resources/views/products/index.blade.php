<x-layouts.app title="Products">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-display text-2xl font-bold">Products</h1>
        <x-ui.button variant="primary" href="{{ route('products.create') }}">
            + Add Product
        </x-ui.button>
    </div>

    @if (session('success'))
        <x-ui.alert variant="success" class="mt-6">{{ session('success') }}</x-ui.alert>
    @endif

    @if (session('error'))
        <x-ui.alert variant="error" class="mt-6">{{ session('error') }}</x-ui.alert>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-ui.stat-card title="Total Products" :value="number_format($totalProducts)">
            <x-slot:icon>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z" />
                    <path d="m3.3 7 8.7 5 8.7-5" />
                    <path d="M12 22V12" />
                </svg>
            </x-slot:icon>
        </x-ui.stat-card>

        <x-ui.stat-card
            title="Inventory Value"
            :value="\App\Models\Product::formatCompactRupiah($inventoryValue)"
            :tooltip="'Rp '.number_format($inventoryValue, 0, ',', '.')"
        >
            <x-slot:icon>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </x-slot:icon>
        </x-ui.stat-card>

        <x-ui.stat-card title="Low Stock" :value="number_format($lowStock)" variant="warning">
            <x-slot:icon>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
            </x-slot:icon>
        </x-ui.stat-card>

        <x-ui.stat-card title="Out of Stock" :value="number_format($outOfStock)" variant="danger">
            <x-slot:icon>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <path d="m15 9-6 6" />
                    <path d="m9 9 6 6" />
                </svg>
            </x-slot:icon>
        </x-ui.stat-card>
    </div>

    {{-- Empty carrier form: every search/filter/per-page control below is
         associated to it via the form="products-filters" attribute, so they
         all submit together as one query string regardless of where they
         sit in the markup (top toolbar, modal, or footer). --}}
    <form id="products-filters" method="GET" action="{{ route('products.index') }}" class="hidden">
        <input type="hidden" name="sort" value="{{ request('sort') }}">
        <input type="hidden" name="direction" value="{{ request('direction') }}">
    </form>

    <x-ui.card class="mt-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <x-ui.input
                    form="products-filters"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search products..."
                    class="w-64"
                />
                <x-ui.button type="submit" form="products-filters" variant="secondary">Search</x-ui.button>

                <button type="button" data-modal-open="filters-modal" class="btn btn-secondary relative">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z" />
                    </svg>
                    Filters
                    @if ($activeFilterCount > 0)
                        <span class="filter-badge">{{ $activeFilterCount }}</span>
                    @endif
                </button>
            </div>

            <form method="POST" action="{{ route('products.sync') }}">
                @csrf
                <x-ui.button type="submit" variant="secondary">Sync Products</x-ui.button>
            </form>
        </div>

        <div class="mt-6">
            <x-product.table :products="$products" :sort="$sort" :direction="$direction" />
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
            </p>

            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-neutral-500 dark:text-neutral-400">
                    <label for="per_page">Rows per page:</label>
                    <select
                        form="products-filters"
                        name="per_page"
                        id="per_page"
                        onchange="this.form.submit()"
                        class="input-field select-field w-auto"
                    >
                        @foreach ([10, 25, 50, 100] as $option)
                            <option value="{{ $option }}" @selected(request('per_page', 10) == $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{ $products->links() }}
            </div>
        </div>
    </x-ui.card>

    {{-- Filters modal --}}
    <div id="filters-modal" data-modal class="fixed inset-0 z-50 hidden">
        <div class="modal-backdrop" data-modal-close></div>

        <div class="relative z-50 flex min-h-full items-start justify-center p-4 sm:items-center">
            <div class="modal-panel">
                <div class="flex items-center justify-between border-b border-neutral-200 px-6 py-4 dark:border-neutral-800">
                    <h2 class="font-display text-lg font-semibold">Filters</h2>
                    <button type="button" data-modal-close class="topbar-icon-btn" aria-label="Close filters">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4 px-6 py-4">
                    <div>
                        <label for="stock_status" class="input-label">Stock status</label>
                        <select form="products-filters" name="stock_status" id="stock_status" class="input-field select-field">
                            <option value="">Any</option>
                            <option value="in-stock" @selected(request('stock_status') === 'in-stock')>In Stock</option>
                            <option value="low-stock" @selected(request('stock_status') === 'low-stock')>Low Stock</option>
                            <option value="out-of-stock" @selected(request('stock_status') === 'out-of-stock')>Out of Stock</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.input
                            form="products-filters"
                            type="number"
                            step="0.01"
                            min="0"
                            name="price_min"
                            label="Price min"
                            value="{{ request('price_min') }}"
                        />
                        <x-ui.input
                            form="products-filters"
                            type="number"
                            step="0.01"
                            min="0"
                            name="price_max"
                            label="Price max"
                            value="{{ request('price_max') }}"
                        />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.input
                            form="products-filters"
                            type="number"
                            min="0"
                            name="stock_min"
                            label="Stock min"
                            value="{{ request('stock_min') }}"
                        />
                        <x-ui.input
                            form="products-filters"
                            type="number"
                            min="0"
                            name="stock_max"
                            label="Stock max"
                            value="{{ request('stock_max') }}"
                        />
                    </div>

                    <div>
                        <label for="source" class="input-label">Source</label>
                        <select form="products-filters" name="source" id="source" class="input-field select-field">
                            <option value="">Any</option>
                            <option value="synced" @selected(request('source') === 'synced')>Synced (FakeStore)</option>
                            <option value="manual" @selected(request('source') === 'manual')>Manual</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-neutral-200 px-6 py-4 dark:border-neutral-800">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Reset</a>
                    <x-ui.button type="submit" form="products-filters" variant="primary">Apply Filters</x-ui.button>
                </div>
            </div>
        </div>
    </div>

    <x-product.delete-modal />
</x-layouts.app>
