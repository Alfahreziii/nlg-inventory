@props(['products'])

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th class="text-right">Price</th>
                <th class="text-right">Stock</th>
                <th>Description</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                @php
                    $status = match (true) {
                        $product->stock === 0 => 'out-of-stock',
                        $product->stock <= 10 => 'low-stock',
                        default => 'in-stock',
                    };
                @endphp
                <tr>
                    <td class="font-medium">{{ $product->name }}</td>
                    <td class="text-right tabular-nums">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <span class="tabular-nums">{{ $product->stock }}</span>
                            <x-ui.badge :status="$status" />
                        </div>
                    </td>
                    <td class="text-neutral-500 dark:text-neutral-400">{{ Str::limit($product->description, 60) }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-ghost px-3 py-1.5">Edit</a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete {{ $product->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-3 py-1.5">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="table-empty">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
