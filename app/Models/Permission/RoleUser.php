<?php

declare(strict_types=1);

namespace App\Models\Permission;

use App\Models\BaseModel;

/**
 * Class RoleUser.
 * @property int $role_id
 * @property int $user_id
 */
final class RoleUser extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'roles_users';

    /**
     * @var string[]
     */
    protected $fillable = [
        'role_id', 'user_id',
    ];
}
