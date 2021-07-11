<?php

declare(strict_types=1);

namespace App\Models\Permission;

use App\Models\BaseModel;

/**
 * Class RolePermission.
 * @property int $role_id
 * @property int $permission_id
 */
final class RolePermission extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'roles_permissions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'role_id', 'permission_id',
    ];
}
