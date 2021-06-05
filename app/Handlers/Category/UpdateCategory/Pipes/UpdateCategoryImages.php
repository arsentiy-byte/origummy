<?php

declare(strict_types=1);

namespace App\Handlers\Category\UpdateCategory\Pipes;

use App\DTO\Category\CategoryDTO;
use App\Handlers\ImagesHandler;
use App\Models\Category\CategoryImage;
use Closure;
use Exception;

/**
 * Class UpdateCategoryImages.
 */
final class UpdateCategoryImages
{
    /**
     * @param CategoryDTO $categoryDTO
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(CategoryDTO $categoryDTO, Closure $next): mixed
    {
        $imagesHandler = new ImagesHandler(240, 'categories');
        $deleteImages = $categoryDTO->getCategoryDeleteImages();
        $images = $categoryDTO->getCategoryImages();

        foreach ($deleteImages as $deleteImage) {
            $image = CategoryImage::where('path', $deleteImage)->first();
            $imagesHandler->deleteImage($image->path);
            $image->delete();
        }

        foreach ($images as $image) {
            $path = $image['path'];
            CategoryImage::create([
                'path' => $path,
                'category_id' => $categoryDTO->categoryID,
            ]);

            $imagesHandler->storeImage($image['data'], $path);
        }

        return $next($categoryDTO);
    }
}
