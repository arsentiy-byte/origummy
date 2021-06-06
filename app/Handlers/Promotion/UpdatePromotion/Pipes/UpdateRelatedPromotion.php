<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\UpdatePromotion\Pipes;

use App\DTO\Promotion\UpdatePromotionDTO;
use App\Models\Promotion\RelatedPromotion;
use Closure;

/**
 * Class UpdateRelatedPromotion.
 */
final class UpdateRelatedPromotion
{
    /**
     * @param UpdatePromotionDTO $promotionDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(UpdatePromotionDTO $promotionDTO, Closure $next): mixed
    {
        RelatedPromotion::where('promotion_id', $promotionDTO->promotion_id)
            ->whereIn('product_id', $promotionDTO->getDeleteRelatedProducts())
            ->delete();

        foreach ($promotionDTO->getRelatedProducts() as $productId) {
            RelatedPromotion::create([
                'promotion_id' => $promotionDTO->promotion_id,
                'product_id' => $productId,
            ]);
        }

        return $next($promotionDTO);
    }
}
