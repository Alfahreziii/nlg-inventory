<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FakeStoreService
{
    protected const API_URL = 'https://fakestoreapi.com/products';

    protected const USD_TO_IDR = 16000;

    /**
     * Fetch products from FakeStore API and sync them into the local database.
     * Idempotent: re-running never creates duplicates (keyed on external_id).
     *
     * @return int Number of products synced.
     */
    public function sync(): int
    {
        $response = Http::timeout(15)->get(self::API_URL)->throw();

        $items = $response->json();

        return DB::transaction(function () use ($items) {
            $count = 0;

            foreach ($items as $item) {
                Product::updateOrCreate(
                    ['external_id' => (string) $item['id']],
                    [
                        'name' => $item['title'],
                        'price' => round($item['price'] * self::USD_TO_IDR, 2),
                        'description' => $item['description'] ?? null,
                        'stock' => rand(0, 100),
                    ]
                );

                $count++;
            }

            return $count;
        });
    }
}
