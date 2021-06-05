<?php

declare(strict_types=1);

namespace App\Handlers\Product\UpdateProduct\Pipes;

use App\DTO\Product\UpdateProductDTO;
use App\Models\Product\ProductRelation;
use Closure;

final class UpdateRelatedProducts
{
    /**
     * @param UpdateProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(UpdateProductDTO $productDTO, Closure $next): mixed
    {
        $relatedProducts = $productDTO->getRelatedProducts();

        ProductRelation::where('main_product_id', $productDTO->product_id)
            ->whereIn('related_product_id', $productDTO->getDeleteRelatedProducts())
            ->delete();

        foreach ($relatedProducts as $productId) {
            ProductRelation::create([
                'main_product_id' => $productDTO->product_id,
                'related_product_id' => $productId,
            ]);
        }

        return $next($productDTO);
    }
}
