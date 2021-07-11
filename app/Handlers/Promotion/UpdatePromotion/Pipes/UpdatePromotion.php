<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\UpdatePromotion\Pipes;

use App\DTO\Promotion\UpdatePromotionDTO;
use App\Models\Promotion\Promotion;
use Closure;

/**
 * Class UpdatePromotion.
 */
final class UpdatePromotion
{
    /**
     * @param UpdatePromotionDTO $promotionDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(UpdatePromotionDTO $promotionDTO, Closure $next): mixed
    {
        $data = array_filter($promotionDTO->getPromotionData(), static fn ($value) => $value !== null);

        if (count($data) === 0) {
            return $next($promotionDTO);
        }

        $promotion = Promotion::findOrFail($promotionDTO->promotion_id);

        $promotion->update($data);

        return $next($promotionDTO);
    }
}
