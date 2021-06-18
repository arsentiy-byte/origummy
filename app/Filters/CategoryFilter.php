<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class CategoryFilter.
 */
final class CategoryFilter extends BaseFilter
{
    public const KEYS_TO_BOOL = [
        'status', 'is_default',
    ];

    /**
     * @param string $title
     * @return Builder
     */
    public function title(string $title): Builder
    {
        return $this->builder->where('title', 'ilike', '%' . $title . '%');
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
     * @param bool $isDefault
     * @return Builder
     */
    public function isDefault(bool $isDefault): Builder
    {
        return $this->builder->where('is_default', $isDefault);
    }

    /**
     * @param int $id
     * @return Builder
     */
    public function id(int $id): Builder
    {
        return $this->builder->where('id', $id);
    }
}
