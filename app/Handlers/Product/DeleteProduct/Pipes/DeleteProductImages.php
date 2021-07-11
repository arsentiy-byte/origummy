<?php

declare(strict_types=1);

namespace App\Handlers\Product\DeleteProduct\Pipes;

use App\DTO\Product\UpdateProductDTO;
use App\Handlers\ImagesHandler;
use App\Models\Product\ProductImage;
use Closure;
use Exception;

final class DeleteProductImages
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
        $images = ProductImage::where('product_id', $productDTO->product_id)->get();

        foreach ($images as $image) {
            $imagesHandler->deleteImage($image->path);
        }

        return $next($productDTO);
    }
}
