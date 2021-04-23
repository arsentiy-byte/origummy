<?php

declare(strict_types=1);

namespace App\Traits;

/**
 * Trait TableNameGetterTrait.
 */
trait TableNameGetterTrait
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return with(new static)->getTable();
    }
}
