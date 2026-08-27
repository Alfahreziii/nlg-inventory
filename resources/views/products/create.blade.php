<x-layouts.app title="Add Product">
    <x-ui.card>
        <h1 class="font-display text-xl font-bold">Add Product</h1>

        <div class="mt-6">
            <x-product.form :action="route('products.store')" method="POST" />
        </div>
    </x-ui.card>
</x-layouts.app>
