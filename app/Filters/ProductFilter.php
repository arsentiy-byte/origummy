<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

final class ProductFilter extends BaseFilter
{
    public const KEYS_TO_INT = [
        'id', 'category_id',
    ];

    /**
     * @param string $title
     * @return Builder
     */
    public function title(string $title): Builder
    {
        return $this->builder->where('title', 'ilike', '%'.$title.'%');
    }

    /**
     * @param bool $status
     * @return Builder
     */
    public function status(bool $status): Builder
    {
        return $this->builder->where('status', $status);
    }

    /**
     * @param int $id
     * @return Builder
     */
    public function id(int $id): Builder
    {
        return $this->builder->where('id', $id);
    }

    /**
     * @param int $categoryId
     * @return Builder
     */
    public function categoryId(int $categoryId): Builder
    {
        return $this->builder->where('category_id', $categoryId);
    }
}
