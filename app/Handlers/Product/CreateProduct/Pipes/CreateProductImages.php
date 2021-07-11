<?php

declare(strict_types=1);

namespace App\Handlers\Product\CreateProduct\Pipes;

use App\DTO\Product\ProductDTO;
use App\Handlers\ImagesHandler;
use App\Models\Product\ProductImage;
use Closure;

/**
 * Class CreateProductImages.
 */
final class CreateProductImages
{
    /**
     * @param ProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(ProductDTO $productDTO, Closure $next)
    {
        $imagesHandler = new ImagesHandler(1000, 'products');
        $images = $imagesHandler->handleSeveralImages($productDTO->getProductImages());

        foreach ($images as $image) {
            $path = $image['path'];
            ProductImage::create([
                'path' => $path,
                'product_id' => $productDTO->product_id,
            ]);

            $imagesHandler->storeImage($image['data'], $path);
        }

        return $next($productDTO);
    }
}
