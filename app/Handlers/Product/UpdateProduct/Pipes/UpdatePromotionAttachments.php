<?php

declare(strict_types=1);

namespace App\Handlers\Product\UpdateProduct\Pipes;

use App\DTO\Product\UpdateProductDTO;
use App\Models\Promotion\ProductPromotion;
use Closure;

final class UpdatePromotionAttachments
{
    /**
     * @param UpdateProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(UpdateProductDTO $productDTO, Closure $next): mixed
    {
        $promotions = $productDTO->getPromotions();

        ProductPromotion::where('product_id', $productDTO->product_id)
            ->whereIn('promotion_id', $productDTO->getDeletePromotions())
            ->delete();

        foreach ($promotions as $promotionId) {
            ProductPromotion::create([
                'product_id' => $productDTO->product_id,
                'promotion_id' => $promotionId,
            ]);
        }

        return $next($productDTO);
    }
}
