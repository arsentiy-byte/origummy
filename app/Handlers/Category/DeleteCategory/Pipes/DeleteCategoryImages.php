<?php

declare(strict_types=1);

namespace App\Handlers\Category\DeleteCategory\Pipes;

use App\DTO\Category\CategoryDTO;
use App\Handlers\ImagesHandler;
use App\Models\Category\CategoryImage;
use Closure;
use Exception;

/**
 * Class DeleteCategoryImages.
 */
final class DeleteCategoryImages
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
        $images = CategoryImage::where('category_id', $categoryDTO->categoryID)->get();

        foreach ($images as $image) {
            $imagesHandler->deleteImage($image->path);
        }

        return $next($categoryDTO);
    }
}
