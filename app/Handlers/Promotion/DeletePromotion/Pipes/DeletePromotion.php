<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\DeletePromotion\Pipes;

use App\DTO\Promotion\UpdatePromotionDTO;
use App\Models\Promotion\Promotion;
use Closure;

/**
 * Class DeletePromotion.
 */
final class DeletePromotion
{
    /**
     * @param UpdatePromotionDTO $promotionDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(UpdatePromotionDTO $promotionDTO, Closure $next): mixed
    {
        $promotion = Promotion::findOrFail($promotionDTO->promotion_id);

        $promotion->delete();

        return $next($promotionDTO);
    }
}
