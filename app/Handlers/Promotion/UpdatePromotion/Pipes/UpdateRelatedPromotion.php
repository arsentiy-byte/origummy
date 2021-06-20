<?php

declare(strict_types=1);

namespace App\Handlers\Promotion\UpdatePromotion\Pipes;

use App\DTO\Promotion\UpdatePromotionDTO;
use App\Models\Promotion\Promotion;
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
        $promotion = Promotion::findOrFail($promotionDTO->promotion_id);

        $fromPromotion = $promotion->relatedProducts->toArray();
        $fromDTO = $promotionDTO->getRelatedProducts();

        $deleteRelatedProducts = $this->getDeleteProducts($fromPromotion, $fromDTO);
        $insertRelatedProducts = $this->getInsertProducts($fromPromotion, $fromDTO);

        RelatedPromotion::where('promotion_id', $promotionDTO->promotion_id)
            ->whereIn('product_id', array_column($deleteRelatedProducts, 'id'))
            ->delete();

        foreach ($insertRelatedProducts as $productId) {
            RelatedPromotion::create([
                'promotion_id' => $promotionDTO->promotion_id,
                'product_id' => $productId,
            ]);
        }

        return $next($promotionDTO);
    }

    /**
     * @param array $fromPromotion
     * @param array $fromDTO
     * @return array
     */
    private function getDeleteProducts(array $fromPromotion, array $fromDTO): array
    {
        return array_filter($fromPromotion, function ($item) use ($fromDTO) {
            return !in_array($item['id'], $fromDTO);
        });
    }

    /**
     * @param array $fromPromotion
     * @param array $fromDTO
     * @return array
     */
    private function getInsertProducts(array $fromPromotion, array $fromDTO): array
    {
        return array_filter($fromDTO, function ($item) use ($fromPromotion) {
            return !in_array($item, array_column($fromPromotion, 'id'));
        });
    }
}
