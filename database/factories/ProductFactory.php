<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Industrial tools & machinery products, grouped by category so name,
     * price, and stock stay realistic together.
     *
     * @var array<int, array{name: string, price: float, stock: int}>
     */
    protected static array $catalog = [
        ['name' => 'Bosch GWS 060 Angle Grinder 4"', 'price' => 685000, 'stock' => 42],
        ['name' => 'Makita HP1630 Impact Drill 13mm', 'price' => 945000, 'stock' => 18],
        ['name' => 'DeWalt DWE575 Circular Saw 7-1/4"', 'price' => 1850000, 'stock' => 12],
        ['name' => 'Hitachi Welding Machine 450 Inverter', 'price' => 3250000, 'stock' => 7],
        ['name' => 'Krisbow Air Compressor 2HP 24L', 'price' => 2100000, 'stock' => 9],
        ['name' => 'Stanley Hydraulic Bottle Jack 5 Ton', 'price' => 425000, 'stock' => 30],
        ['name' => 'Tekiro Combination Wrench Set 8-24mm', 'price' => 385000, 'stock' => 55],
        ['name' => 'Bosch GBH 2-26 Rotary Hammer Drill', 'price' => 2450000, 'stock' => 15],
        ['name' => 'Makita 9403 Belt Sander 100x610mm', 'price' => 1620000, 'stock' => 11],
        ['name' => 'Total Industrial Bench Vise 6"', 'price' => 510000, 'stock' => 26],
        ['name' => 'Yamaha Generator EF2000iS 2000W', 'price' => 6750000, 'stock' => 4],
        ['name' => 'Krisbow Digital Torque Wrench 1/2"', 'price' => 890000, 'stock' => 20],
        ['name' => 'Bosch GSB 550 Impact Drill', 'price' => 720000, 'stock' => 33],
        ['name' => 'Makita MT81 Chain Saw 16"', 'price' => 1975000, 'stock' => 8],
        ['name' => 'Tekiro Hydraulic Floor Jack 3 Ton', 'price' => 980000, 'stock' => 14],
        ['name' => 'Total Cordless Drill Driver 12V', 'price' => 545000, 'stock' => 0],
        ['name' => 'Krisbow Industrial Ladder Aluminium 6-Step', 'price' => 1250000, 'stock' => 6],
        ['name' => 'Bosch GCO 220 Metal Cut-Off Saw', 'price' => 3480000, 'stock' => 3],
        ['name' => 'Makita GA9020 Angle Grinder 9"', 'price' => 2150000, 'stock' => 10],
        ['name' => 'Tekiro Digital Caliper 150mm', 'price' => 275000, 'stock' => 48],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static int $cursor = 0;

    public function definition(): array
    {
        $item = static::$catalog[static::$cursor % count(static::$catalog)];
        static::$cursor++;

        return [
            'name' => $item['name'],
            'price' => $item['price'],
            'stock' => $item['stock'],
            'description' => fake()->boolean(80)
                ? fake()->sentence(rand(8, 16))
                : null,
            'external_id' => null,
        ];
    }
}
