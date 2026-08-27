<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\FakeStoreService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [10, 25, 50, 100], true)) {
            $perPage = 10;
        }

        $sort = $request->input('sort');

        if (! in_array($sort, ['name', 'price', 'stock'], true)) {
            $sort = 'created_at';
        }

        $direction = $request->input('direction');

        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $products = Product::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->string('search')->toString().'%');
            })
            ->when($request->filled('stock_status'), function ($query) use ($request) {
                match ($request->input('stock_status')) {
                    'out-of-stock' => $query->where('stock', 0),
                    'low-stock' => $query->whereBetween('stock', [1, 10]),
                    'in-stock' => $query->where('stock', '>', 10),
                    default => null,
                };
            })
            ->when($request->filled('price_min') && is_numeric($request->input('price_min')), function ($query) use ($request) {
                $query->where('price', '>=', $request->input('price_min'));
            })
            ->when($request->filled('price_max') && is_numeric($request->input('price_max')), function ($query) use ($request) {
                $query->where('price', '<=', $request->input('price_max'));
            })
            ->when($request->filled('stock_min') && is_numeric($request->input('stock_min')), function ($query) use ($request) {
                $query->where('stock', '>=', $request->input('stock_min'));
            })
            ->when($request->filled('stock_max') && is_numeric($request->input('stock_max')), function ($query) use ($request) {
                $query->where('stock', '<=', $request->input('stock_max'));
            })
            ->when($request->filled('source'), function ($query) use ($request) {
                match ($request->input('source')) {
                    'synced' => $query->whereNotNull('external_id'),
                    'manual' => $query->whereNull('external_id'),
                    default => null,
                };
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();

        $activeFilterCount = collect(['stock_status', 'price_min', 'price_max', 'stock_min', 'stock_max', 'source'])
            ->filter(fn ($key) => $request->filled($key))
            ->count();

        $totalProducts = Product::count();
        $inventoryValue = (float) Product::sum(DB::raw('price * stock'));
        $lowStock = Product::whereBetween('stock', [1, 10])->count();
        $outOfStock = Product::where('stock', 0)->count();

        return view('products.index', compact(
            'products',
            'activeFilterCount',
            'sort',
            'direction',
            'totalProducts',
            'inventoryValue',
            'lowStock',
            'outOfStock',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Sync products from the FakeStore API.
     */
    public function sync(FakeStoreService $service): RedirectResponse
    {
        try {
            $count = $service->sync();

            return redirect()->route('products.index')
                ->with('success', "Synced {$count} products from FakeStore API.");
        } catch (Throwable $e) {
            return redirect()->route('products.index')
                ->with('error', 'Failed to sync products: '.$e->getMessage());
        }
    }
}
