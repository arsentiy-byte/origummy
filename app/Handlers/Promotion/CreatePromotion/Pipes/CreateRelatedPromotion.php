<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\CreatePromotion\Pipes;

use App\DTO\Promotion\PromotionDTO;
use App\Models\Promotion\RelatedPromotion;
use Closure;

/**
 * Class CreateRelatedPromotion.
 */
final class CreateRelatedPromotion
{
    /**
     * @param PromotionDTO $promotionDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(PromotionDTO $promotionDTO, Closure $next): mixed
    {
        foreach ($promotionDTO->relatedProducts as $productId) {
            RelatedPromotion::create([
                'promotion_id' => $promotionDTO->promotion_id,
                'product_id' => $productId,
            ]);
        }

        return $next($promotionDTO);
    }
}
