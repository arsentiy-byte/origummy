<?php

declare(strict_types=1);

namespace App\Handlers\Product\CreateProduct\Pipes;

use App\DTO\Product\ProductDTO;
use App\Models\Promotion\ProductPromotion;
use Closure;

/**
 * Class AttachPromotions.
 */
final class AttachPromotions
{
    /**
     * @param ProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(ProductDTO $productDTO, Closure $next): mixed
    {
        $promotions = $productDTO->getPromotions();

        foreach ($promotions as $promotionId) {
            ProductPromotion::create([
                'product_id' => $productDTO->product_id,
                'promotion_id' => $promotionId,
            ]);
        }

        return $next($productDTO);
    }
}
