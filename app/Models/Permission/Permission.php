<?php

declare(strict_types=1);

namespace App\Models\Permission;

use App\Models\BaseModel;

/**
 * Class Permission.
 * @property string $name
 * @property string $description
 * @property string $route
 */
final class Permission extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'route',
    ];
}
