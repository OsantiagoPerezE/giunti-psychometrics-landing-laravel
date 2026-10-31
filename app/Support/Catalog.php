<?php

namespace App\Support;

class Catalog
{
    private const MONTHS = [
        1 => 'gennaio',
        'febbraio',
        'marzo',
        'aprile',
        'maggio',
        'giugno',
        'luglio',
        'agosto',
        'settembre',
        'ottobre',
        'novembre',
        'dicembre',
    ];

    public static function products(): array
    {
        return config('catalog.products');
    }

    public static function find(string $id): ?array
    {
        foreach (self::products() as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }

        return null;
    }

    public static function hasPromo(array $p): bool
    {
        return isset($p['discount_price']) && $p['discount_price'] < $p['price'];
    }

    public static function finalPrice(array $p): float
    {
        return self::hasPromo($p) ? $p['discount_price'] : $p['price'];
    }

    public static function discountPercent(array $p): int
    {
        return self::hasPromo($p) ? (int) round((1 - self::finalPrice($p) / $p['price']) * 100) : 0;
    }

    public static function formatPrice(float $value): string
    {
        return number_format($value, 2, ',', '.') . ' €';
    }

    public static function formatDate(string $iso): string
    {
        [$y, $m, $d] = array_map('intval', explode('-', $iso));

        return "{$d} " . self::MONTHS[$m] . " {$y}";
    }

    public static function priceRange(): array
    {
        $prices = array_map([self::class, 'finalPrice'], self::products());

        return [(int) floor(min($prices)), (int) ceil(max($prices))];
    }
}
