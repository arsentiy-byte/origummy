<?php

declare(strict_types=1);

namespace App\Handlers\Product\UpdateProduct\Pipes;

use App\DTO\Product\UpdateProductDTO;
use App\Models\Product\Product;
use Closure;

/**
 * Class UpdateProduct.
 */
final class UpdateProduct
{
    /**
     * @param UpdateProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(UpdateProductDTO $productDTO, Closure $next): mixed
    {
        $data = array_filter($productDTO->getProductData(), static fn ($value) => $value !== null);

        if (count($data) === 0) {
            return $next($productDTO);
        }

        $product = Product::findOrFail($productDTO->product_id);

        $product->update($data);

        return $next($productDTO);
    }
}
