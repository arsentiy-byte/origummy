<?php

declare(strict_types=1);

namespace App\Models\Materials;

use App\Models\BaseModel;
use App\Traits\Materials\MaterialRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class JournalIssue.
 * @property int $j_issue_id
 * @property int $journal_id
 * @property int $issue
 * @property string $issue_name
 * @property int $page_num
 * @property string $diagonal
 * @property string $issue_date
 * @property-read Journal $journal
 */
final class JournalIssue extends BaseModel
{
    use MaterialRelationships;

    protected const ALIAS = 'ji';

    /**
     * @var string
     */
    protected $table = 'lib_journal_issues';

    /**
     * @var string
     */
    protected $primaryKey = 'j_issue_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'journal_id',
        'issue',
        'issue_name',
        'page_num',
        'diagonal',
        'issue_date',
    ];

    /**
     * @return BelongsTo|null
     */
    public function publisher(): ?BelongsTo
    {
        return null;
    }

    /**
     * @return HasOne|null
     */
    public function type(): ?HasOne
    {
        return null;
    }

    /**
     * @return BelongsTo
     */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }
}
