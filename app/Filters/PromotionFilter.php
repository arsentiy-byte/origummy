<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class PromotionFilter.
 */
final class PromotionFilter extends BaseFilter
{
    public const KEYS_TO_INT = [
        'id', 'type_id',
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
     * @param int $typeId
     * @return Builder
     */
    public function typeId(int $typeId): Builder
    {
        return $this->builder->where('type_id', $typeId);
    }
}
