<?php

declare(strict_types=1);

namespace App\Handlers\Product\CreateProduct\Pipes;

use App\DTO\Product\ProductDTO;
use App\Models\Product\Product;
use Closure;

/**
 * Class CreateProduct.
 */
final class CreateProduct
{
    /**
     * @param ProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(ProductDTO $productDTO, Closure $next): mixed
    {
        $product = Product::create($productDTO->getProductData());
        $productDTO->product_id = $product->id;

        return $next($productDTO);
    }
}
