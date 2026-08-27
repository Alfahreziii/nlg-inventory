<x-layouts.app title="Edit Product">
    <x-ui.card>
        <h1 class="font-display text-xl font-bold">Edit Product</h1>

        <div class="mt-6">
            <x-product.form
                :product="$product"
                :action="route('products.update', $product)"
                method="PUT"
            />
        </div>
    </x-ui.card>
</x-layouts.app>
