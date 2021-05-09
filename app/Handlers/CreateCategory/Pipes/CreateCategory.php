<?php

declare(strict_types=1);

namespace App\Handlers\CreateCategory\Pipes;

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
        $category = Category::create($categoryDTO->getCategoryData());
        $categoryDTO->categoryID = $category->id;

        return $next($categoryDTO);
    }
}
