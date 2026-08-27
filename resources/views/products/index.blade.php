<x-layouts.app title="Products">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="font-display text-2xl font-bold">Products</h1>
        <x-ui.button variant="primary" href="{{ route('products.create') }}">
            + Add Product
        </x-ui.button>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-6">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-error mt-6">{{ session('error') }}</div>
    @endif

    <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
            <x-ui.input name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-64" />
            <x-ui.button type="submit" variant="secondary">Search</x-ui.button>
        </form>

        <form method="POST" action="{{ route('products.sync') }}">
            @csrf
            <x-ui.button type="submit" variant="secondary">Sync Products</x-ui.button>
        </form>
    </div>

    <div class="mt-6">
        <x-product.table :products="$products" />
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-layouts.app>
