@props(['product' => null, 'action', 'method' => 'POST'])

<form method="POST" action="{{ $action }}" class="space-y-5">
    @csrf
    @if (strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <x-ui.input name="name" label="Product name" :value="$product->name ?? ''" />

    <x-ui.input
        name="price"
        type="number"
        step="0.01"
        min="0"
        label="Price (IDR)"
        :value="$product->price ?? ''"
    />

    <x-ui.input
        name="stock"
        type="number"
        min="0"
        label="Stock"
        :value="$product->stock ?? ''"
    />

    <x-ui.textarea
        name="description"
        label="Description"
        rows="4"
        :value="$product->description ?? ''"
    />

    <div class="flex items-center gap-3 pt-2">
        <x-ui.button type="submit" variant="primary">Save Product</x-ui.button>
        <x-ui.button variant="ghost" href="{{ route('products.index') }}">Cancel</x-ui.button>
    </div>
</form>
