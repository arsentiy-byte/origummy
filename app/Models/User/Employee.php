<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

/**
 * Class Employee.
 *
 * @property string $name
 * @property string $status
 * @property-read string|null $user_cid
 * @property-read bool $is_admin
 * @property-read int $id
 * @property-read string $surname
 * @property-read string $username
 * @property-read UserCard $userCard
 */
final class Employee extends Authenticatable implements UserCidAttribute
{
    use HasApiTokens, HasFactory;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'dbmaster.employee';

    /**
     * @var string
     */
    protected $primaryKey = 'emp_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'degree_id',
        'ip',
        'status',
        'passw',
        'passw2',
        'state',
        'web_lan',
        'pswchdate',
        'reg_date',
        'name_native',
        'surname_native',
        'patronymic',
        'old_emp_id',
        'wage_rate',
        'academic_rank',
        'last_login_info',
        'attempt_count',
        'attempt_date',
    ];

    /**
     * @var string[]
     */
    protected $visible = [
        'name',
        'status',
        'is_admin',
        'user_cid',
        'surname',
        'id',
        'username',
    ];

    /**
     * @var string[]
     */
    protected $appends = ['is_admin', 'user_cid', 'surname', 'id', 'username'];

    /**
     * @return string|null
     */
    public function getUserCidAttribute(): string | null
    {
        $userCard = DB::table('lib_user_cards as uc')->select('uc.user_cid')->where('uc.emp_id', $this->emp_id)->first();

        return ! empty($userCard) ? $userCard->user_cid : null;
    }

    /**
     * @return bool
     *
     * @psalm-suppress InvalidScalarArgument
     */
    public function getIsAdminAttribute(): bool
    {
        $permission = self::query()
            ->select(DB::raw('dbmaster.GetPermitByUser(emp_id, ai.acc_id) as user_permit'),
            DB::raw('dbmaster.getpermitByUserJob(emp_id, ai.acc_id) as position_permit'),
            'ai.acc_level')
            ->leftJoin('dbmaster.acc_info as ai', 'ai.acc_id', '=', 7)
            ->where('emp_id', '=', $this->emp_id)
            ->first();
        if (! empty($permission)) {
            $permitted = $permission->acc_level == '2' || $permission->user_permit == '1'
                || $permission->position_permit == '1';
        }

        return $permitted ?? false;
    }

    /**
     * @return string
     */
    public function getIdAttribute(): string
    {
        return $this->emp_id;
    }

    /**
     * @return string
     */
    public function getSurnameAttribute(): string
    {
        return $this->sname;
    }

    /**
     * @return string
     */
    public function getUsernameAttribute(): string
    {
        return $this->hname;
    }

    /**
     * @return HasOne
     */
    public function userCard(): HasOne
    {
        return $this->hasOne(UserCard::class, 'emp_id');
    }
}
