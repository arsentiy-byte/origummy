<?php

declare(strict_types=1);

namespace App\Models\Permission;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Role.
 * @property string $name
 * @property string $prefix
 * @property string $description
 * @property-read Permission[] $permissions
 */
final class Role extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'prefix', 'description',
    ];

    /**
     * @return HasManyThrough
     */
    public function permissions(): HasManyThrough
    {
        return $this->hasManyThrough(Permission::class, RolePermission::class, 'role_id', 'permission_id');
    }
}
