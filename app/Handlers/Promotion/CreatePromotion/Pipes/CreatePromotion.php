<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\CreatePromotion\Pipes;

use App\DTO\Promotion\PromotionDTO;
use App\Models\Promotion\Promotion;
use Closure;

/**
 * Class CreatePromotion.
 */
final class CreatePromotion
{
    /**
     * @param PromotionDTO $promotionDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(PromotionDTO $promotionDTO, Closure $next): mixed
    {
        $promotion = Promotion::create($promotionDTO->getPromotionData());
        $promotionDTO->promotion_id = $promotion->id;

        return $next($promotionDTO);
    }
}
