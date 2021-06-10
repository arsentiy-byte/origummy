<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Product\Product;
use App\Models\Promotion\Promotion;
use App\Models\Promotion\PromotionType;
use Illuminate\Database\Eloquent\Collection;

/**
 * Trait OrderTrait.
 */
trait OrderTrait
{
    /**
     * @param Product[] $products
     * @return array
     */
    protected function filterProducts(array $products): array
    {
        $result = [];
        foreach ($products as $product) {
            $giftPromotions = $this->getGiftPromotionsIfExist($product->promotions);
            $result[] = [
                'title' => $product->title,
                'count' => $product->orderCount,
                'promotions' => $giftPromotions,
            ];
        }

        return $result;
    }

    /**
     * @param Collection $promotions
     * @return Promotion[]
     */
    protected function getGiftPromotionsIfExist(Collection $promotions): array
    {
        $result = [];
        foreach ($promotions->toArray() as $promotion) {
            if ($promotion['type']['name'] === PromotionType::NAME_GIFT) {
                $result[] = $promotion;
            }
        }

        return $result;
    }

    /**
     * @param Product[] $products
     * @return float
     */
    protected function getTotalPrice(array $products): float
    {
        return (float) array_sum(array_column($products, 'price'));
    }
}
