@props(['products', 'sort' => null, 'direction' => 'desc'])

@php
    $sortLink = function (string $column) use ($sort, $direction) {
        if ($sort !== $column) {
            return request()->fullUrlWithQuery(['sort' => $column, 'direction' => 'asc', 'page' => null]);
        }

        if ($direction === 'asc') {
            return request()->fullUrlWithQuery(['sort' => $column, 'direction' => 'desc', 'page' => null]);
        }

        return request()->fullUrlWithQuery(['sort' => null, 'direction' => null, 'page' => null]);
    };
@endphp

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Actions</th>
                <th>
                    <a href="{{ $sortLink('name') }}" class="table-sort-link">
                        Name
                        @if ($sort === 'name')
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                @if ($direction === 'asc')
                                    <path d="m18 15-6-6-6 6" />
                                @else
                                    <path d="m6 9 6 6 6-6" />
                                @endif
                            </svg>
                        @endif
                    </a>
                </th>
                <th class="cell-nowrap">
                    <a href="{{ $sortLink('price') }}" class="table-sort-link">
                        Price
                        @if ($sort === 'price')
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                @if ($direction === 'asc')
                                    <path d="m18 15-6-6-6 6" />
                                @else
                                    <path d="m6 9 6 6 6-6" />
                                @endif
                            </svg>
                        @endif
                    </a>
                </th>
                <th class="cell-nowrap text-right">
                    <a href="{{ $sortLink('stock') }}" class="table-sort-link justify-end">
                        Stock
                        @if ($sort === 'stock')
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                @if ($direction === 'asc')
                                    <path d="m18 15-6-6-6 6" />
                                @else
                                    <path d="m6 9 6 6 6-6" />
                                @endif
                            </svg>
                        @endif
                    </a>
                </th>
                <th>Description</th>
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
                    <td>
                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('products.edit', $product) }}"
                                class="btn-icon btn-icon-edit"
                                title="Edit"
                                aria-label="Edit {{ $product->name }}"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z" />
                                </svg>
                            </a>

                            <button
                                type="button"
                                data-modal-open="delete-modal"
                                data-action="{{ route('products.destroy', $product) }}"
                                data-name="{{ $product->name }}"
                                class="btn-icon btn-icon-danger"
                                title="Delete"
                                aria-label="Delete {{ $product->name }}"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td>
                        <div class="cell-clamp-2 font-medium" title="{{ $product->name }}">{{ $product->name }}</div>
                    </td>
                    <td class="cell-nowrap tabular-nums">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="cell-nowrap text-right">
                        <div class="flex items-center justify-end gap-2">
                            <span class="tabular-nums">{{ $product->stock }}</span>
                            <x-ui.badge :status="$status" />
                        </div>
                    </td>
                    <td class="text-neutral-500 dark:text-neutral-400">{{ Str::limit($product->description, 60) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="table-empty">No products found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
