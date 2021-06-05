<?php

declare(strict_types=1);

namespace App\Handlers\Category\DeleteCategory\Pipes;

use App\DTO\Category\CategoryDTO;
use App\Models\Category\Category;
use Closure;

/**
 * Class DeleteCategory.
 */
final class DeleteCategory
{
    /**
     * @param CategoryDTO $categoryDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(CategoryDTO $categoryDTO, Closure $next): mixed
    {
        $category = Category::findOrFail($categoryDTO->categoryID);

        $category->delete();

        return $next($categoryDTO);
    }
}
