<?php

declare(strict_types=1);

namespace App\Handlers\Product\UpdateProduct\Pipes;

use App\DTO\Product\UpdateProductDTO;
use App\Handlers\ImagesHandler;
use App\Models\Product\ProductImage;
use Closure;
use Exception;

final class UpdateProductImages
{
    /**
     * @param UpdateProductDTO $productDTO
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(UpdateProductDTO $productDTO, Closure $next): mixed
    {
        $imagesHandler = new ImagesHandler(1000, 'products');
        $deleteImages = $productDTO->getProductDeleteImages();
        $images = $productDTO->getProductImages();

        foreach ($deleteImages as $deleteImage) {
            $image = ProductImage::where('path', $deleteImage)->first();
            $imagesHandler->deleteImage($image->path);
            $image->delete();
        }

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
