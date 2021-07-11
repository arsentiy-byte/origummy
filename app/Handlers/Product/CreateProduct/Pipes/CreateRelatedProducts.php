<?php

declare(strict_types=1);

namespace App\Handlers\Product\CreateProduct\Pipes;

use App\DTO\Product\ProductDTO;
use App\Models\Product\ProductRelation;
use Closure;

/**
 * Class CreateRelatedProducts.
 */
final class CreateRelatedProducts
{
    /**
     * @param ProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(ProductDTO $productDTO, Closure $next): mixed
    {
        $relatedProducts = $productDTO->getRelatedProducts();

        foreach ($relatedProducts as $productId) {
            ProductRelation::create([
                'main_product_id' => $productDTO->product_id,
                'related_product_id' => $productId,
            ]);
        }

        return $next($productDTO);
    }
}
