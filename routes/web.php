<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::post('products/sync', [ProductController::class, 'sync'])->name('products.sync');
Route::resource('products', ProductController::class);
