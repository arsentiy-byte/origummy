<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

/**
 * Class Student.
 *
 * @property string $name
 * @property string $surname
 * @property int $class
 * @property string $status
 * @property string $edu_level
 * @property-read int $id
 * @property-read string $username
 */
final class Student extends Authenticatable implements UserCidAttribute
{
    use HasApiTokens, HasFactory;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'dbmaster.students';

    /**
     * @var string
     */
    protected $primaryKey = 'stud_id';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'class',
        'status',
        'passw',
        'web_lan',
        'last_psw_set_date',
        'emp_id',
        'type',
        'name_native',
        'surname_native',
        'old_sdu_id',
        'patronymic',
        'prog_code_reg',
        'prog_year_reg',
        'last_login_info',
        'attempt_count',
        'attempt_date',
        'edu_level',
        'entrance_year',
        'study_count',
    ];

    /**
     * @var string[]
     */
    protected $visible = [
        'name',
        'surname',
        'class',
        'status',
        'edu_level',
    ];

    protected $appends = ['user_cid', 'username', 'id'];

    /**
     * @return string|null
     */
    public function getUserCidAttribute(): string | null
    {
        $userCard = DB::table('lib_user_cards as uc')->select('uc.user_cid')->where('uc.stud_id', $this->stud_id)->first();

        return ! empty($userCard) ? $userCard->user_cid : null;
    }

    /**
     * @return string
     */
    public function getUsernameAttribute(): string
    {
        return $this->stud_id;
    }

    /**
     * @return string
     */
    public function getIdAttribute(): string
    {
        return $this->stud_id;
    }
}
