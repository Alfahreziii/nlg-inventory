<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    /**
     * Return the local product list as JSON.
     */
    public function index(): JsonResponse
    {
        return response()->json(Product::latest()->get());
    }
}
