<?php

declare(strict_types=1);

namespace App\Models\Materials;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ReserveList.
 * @property int $lib_reserve_id
 * @property string $user_cid
 * @property int $book_id
 * @property int $j_issue_id
 * @property int $disc_id
 * @property string $action_date
 * @property string $end_date
 * @property int $status
 * @property string $email_send_date
 * @property-read Book $book
 * @property-read JournalIssue $journalIssue
 * @property-read Disc $disc
 */
final class ReserveList extends BaseModel
{
    protected const ALIAS = 'rl';

    /**
     * @var string
     */
    protected $table = 'lib_reserve_list';

    /**
     * @var string
     */
    protected $primaryKey = 'lib_reserve_id';

    /**
     * @var string[]
     */
    protected $fillable = ['user_cid', 'book_id', 'j_issue_id', 'disc_id', 'action_date', 'end_date', 'status', 'email_send_date'];

    /**
     * @return BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    /**
     * @return BelongsTo
     */
    public function journalIssue(): BelongsTo
    {
        return $this->belongsTo(JournalIssue::class, 'j_issue_id');
    }

    /**
     * @return BelongsTo
     */
    public function disc(): BelongsTo
    {
        return $this->belongsTo(Disc::class, 'disc_id');
    }
}
