<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'external_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    /**
     * Format a rupiah amount as a compact Indonesian string, e.g.
     * 2818928760 -> "Rp 2,82 M", 45000000 -> "Rp 45 Jt", 750000 -> "Rp 750 Rb".
     */
    public static function formatCompactRupiah(float|int|string $value): string
    {
        $value = (float) $value;

        $units = [
            1_000_000_000_000 => 'T',
            1_000_000_000 => 'M',
            1_000_000 => 'Jt',
            1_000 => 'Rb',
        ];

        foreach ($units as $threshold => $suffix) {
            if (abs($value) >= $threshold) {
                $formatted = number_format($value / $threshold, 2, ',', '.');
                $formatted = rtrim(rtrim($formatted, '0'), ',');

                return "Rp {$formatted} {$suffix}";
            }
        }

        return 'Rp '.number_format($value, 0, ',', '.');
    }
}
