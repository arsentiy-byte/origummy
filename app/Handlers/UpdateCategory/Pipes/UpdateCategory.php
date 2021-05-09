<?php

declare(strict_types=1);

namespace App\Handlers\UpdateCategory\Pipes;

use App\DTO\Category\CategoryDTO;
use App\Models\Category\Category;
use Closure;

/**
 * Class UpdateCategory.
 */
final class UpdateCategory
{
    /**
     * @param CategoryDTO $categoryDTO
     * @param Closure $next
     * @return mixed
     */
    public function handle(CategoryDTO $categoryDTO, Closure $next): mixed
    {
        $data = array_filter($categoryDTO->getCategoryData(), static fn ($value) => $value !== null);

        if (count($data) === 0) {
            return $next($categoryDTO);
        }

        $category = Category::findOrFail($categoryDTO->categoryID);

        $category->update($data);

        return $next($categoryDTO);
    }
}
