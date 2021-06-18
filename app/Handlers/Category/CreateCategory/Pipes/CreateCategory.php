<?php

declare(strict_types=1);

namespace App\Handlers\Category\CreateCategory\Pipes;

use App\DTO\Category\CategoryDTO;
use App\Models\Category\Category;
use Closure;

/**
 * Class CreateCategory.
 */
final class CreateCategory
{
    /**
     * @param CategoryDTO $categoryDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(CategoryDTO $categoryDTO, Closure $next): mixed
    {
        if ($categoryDTO->isDefault) {
            Category::where('is_default', true)->update([
                'is_default' => false
            ]);
        }

        $category = Category::create($categoryDTO->getCategoryData());
        $categoryDTO->categoryID = $category->id;

        return $next($categoryDTO);
    }
}
