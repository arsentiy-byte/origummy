<?php

declare(strict_types=1);

namespace App\Models\User;

/**
 * Interface UserCidAttribute.
 */
interface UserCidAttribute
{
    /**
     * @return string|null
     */
    public function getUserCidAttribute(): string | null;
}
