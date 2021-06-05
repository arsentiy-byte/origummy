<?php

declare(strict_types=1);

namespace App\Handlers\Product\DeleteProduct\Pipes;

use App\DTO\Product\UpdateProductDTO;
use App\Models\Product\Product;
use Closure;

final class DeleteProduct
{
    /**
     * @param UpdateProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(UpdateProductDTO $productDTO, Closure $next): mixed
    {
        $product = Product::findOrFail($productDTO->product_id);

        $product->delete();

        return $next($productDTO);
    }
}
