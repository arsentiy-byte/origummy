<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserCard.
 * @property string $user_cid
 * @property int $stud_id
 * @property int $emp_id
 * @property string $name
 * @property string $surname
 * @property string $psw
 * @property int $attempt_count
 * @property string $attempt_date
 * @property int $is_active
 * @property int $last_login_info
 * @property Student|Employee $user
 */
final class UserCard extends BaseModel
{
    protected const ALIAS = 'uc';

    /**
     * @var string
     */
    protected $table = 'lib_user_cards';

    /**
     * @var string
     */
    protected $primaryKey = 'user_cid';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_cid', 'stud_id', 'emp_id', 'name', 'surname', 'psw', 'attempt_count', 'attempt_date', 'is_active', 'last_login_info',
    ];

    /**
     * @return BelongsTo|null
     */
    public function user(): ?BelongsTo
    {
        if (! empty($this->stud_id)) {
            return $this->belongsTo(Student::class, 'stud_id');
        }

        if (! empty($this->emp_id)) {
            return $this->belongsTo(Employee::class, 'emp_id');
        }

        return null;
    }
}
