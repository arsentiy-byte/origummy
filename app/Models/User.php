<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Permission\Role;
use App\Models\Permission\RolePermission;
use App\Models\Permission\RoleUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User.
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $phone
 * @property string $address
 * @property bool $is_admin
 * @property-read Role[] $roles
 */
final class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'password', 'phone', 'address', 'is_admin',
    ];

    /**
     * @var string[]
     */
    protected $hidden = ['password'];

    /**
     * @return HasManyThrough
     */
    public function roles(): HasManyThrough
    {
        return $this->hasManyThrough(Role::class, RoleUser::class, 'user_id', 'id');
    }

    /**
     * @param int $permission_id
     * @return bool
     */
    public function hasPermission(int $permission_id): bool
    {
        $permission = RolePermission::query()->where('permission_id', $permission_id)->first();
        if (empty($permission)) {
            return false;
        }

        return RoleUser::query()->where('role_id', $permission->role_id)->where('user_id', $this->getKey())->count() > 0;
    }
}
