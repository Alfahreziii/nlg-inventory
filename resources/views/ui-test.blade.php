<x-layouts.app title="UI Component Test">
    <div class="space-y-10">

        <section>
            <h2 class="font-display text-lg font-semibold">Buttons</h2>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <x-ui.button variant="primary">Primary</x-ui.button>
                <x-ui.button variant="secondary">Secondary</x-ui.button>
                <x-ui.button variant="ghost">Ghost</x-ui.button>
                <x-ui.button variant="danger">Danger</x-ui.button>
                <x-ui.button variant="primary" disabled>Primary disabled</x-ui.button>
                <x-ui.button variant="secondary" disabled>Secondary disabled</x-ui.button>
            </div>
        </section>

        <section>
            <h2 class="font-display text-lg font-semibold">Badges</h2>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <x-ui.badge status="in-stock" />
                <x-ui.badge status="low-stock" />
                <x-ui.badge status="out-of-stock" />
            </div>
        </section>

        <section>
            <h2 class="font-display text-lg font-semibold">Inputs</h2>
            <x-ui.card class="mt-4 max-w-md space-y-4">
                <x-ui.input name="product_name" label="Product name" value="Bosch GWS 060 Angle Grinder" />
                <x-ui.input name="price" type="number" label="Price" value="685000" />
                <x-ui.input name="sku" label="SKU (with error)" />
                <x-ui.textarea name="description" label="Description" value="Deskripsi produk contoh untuk pengetesan komponen textarea." />
            </x-ui.card>
        </section>

        <section>
            <h2 class="font-display text-lg font-semibold">Card</h2>
            <x-ui.card class="mt-4 max-w-md">
                <h3 class="font-display font-semibold">Card title</h3>
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                    Surface card dengan border tipis, shadow-sm, dan radius standar.
                </p>
            </x-ui.card>
        </section>

    </div>
</x-layouts.app>
