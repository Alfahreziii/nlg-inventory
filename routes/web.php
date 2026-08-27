<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::post('products/sync', [ProductController::class, 'sync'])->name('products.sync');
Route::resource('products', ProductController::class);

// Temporary — remove once product create/edit views exist.
Route::get('/ui-test', function () {
    $errors = validator(['sku' => ''], ['sku' => 'required'])->errors();

    return view('ui-test', compact('errors'));
});
