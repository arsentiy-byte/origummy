<?php

declare(strict_types=1);

namespace App\Handlers\Category\CreateCategory\Pipes;

use App\DTO\Category\CategoryDTO;
use App\Handlers\ImagesHandler;
use App\Models\Category\CategoryImage;
use Closure;

/**
 * Class CreateCategoryImages.
 */
final class CreateCategoryImages
{
    /**
     * @param CategoryDTO $categoryDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(CategoryDTO $categoryDTO, Closure $next): mixed
    {
        $imagesHandler = new ImagesHandler(240, 'categories');
        $images = $imagesHandler->handleSeveralImages($categoryDTO->getCategoryImages());

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
