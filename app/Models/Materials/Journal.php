<?php

declare(strict_types=1);

namespace App\Models\Materials;

use App\Models\Acquisition\Item;
use App\Models\Acquisition\Publisher;
use App\Models\BaseModel;
use App\Traits\Materials\MaterialAdditionalAttributes;
use App\Traits\Materials\MaterialRelationships;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Journal.
 * @property int $journal_id
 * @property string $isbn
 * @property string $title
 * @property int $publisher_id
 * @property int $publisher_interval_id
 * @property int $borc_verme
 * @property string $diagonal
 * @property int $pub_year
 * @property string $pub_city
 * @property string $editor
 * @property int $page_num
 * @property string $seriya
 * @property int $old_id
 * @property string $parallel_title
 * @property string $title_related_info
 * @property string $pub_info
 * @property int $issue_number
 * @property string $issue_date
 * @property string $temp_publisher_title
 * @property string $language
 * @property string $callnumber
 * @property-read Author[]|string $authors
 * @property-read Publisher $publisher
 * @property-read Type|string $type
 * @property-read ReserveList[] $reserveList
 * @property-read Item[] $items
 * @property-read string|null $type_key
 * @property-read int|null $status
 * @property-read int|null $availability
 */
final class Journal extends BaseModel
{
    use MaterialRelationships, MaterialAdditionalAttributes;

    protected const ALIAS = 'j';

    /**
     * @var string
     */
    protected $table = 'lib_journals';

    /**
     * @var string
     */
    protected $primaryKey = 'journal_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'isbn',
        'title',
        'publisher_id',
        'publish_interval_id',
        'borc_verme',
        'diagonal',
        'pub_year',
        'pub_city',
        'editor',
        'page_num',
        'seriya',
        'old_id',
        'parallel_title',
        'title_related_info',
        'pub_info',
        'issue_number',
        'issue_date',
        'temp_publisher_title',
        'language',
        'type',
    ];

    /**
     * @return HasManyThrough
     */
    public function authors(): HasManyThrough
    {
        return $this->hasManyThrough(Author::class, JournalIssue::class, $this->primaryKey, 'j_issue_id');
    }

    /**
     * @return HasManyThrough
     */
    public function reserveList(): HasManyThrough
    {
        return $this->hasManyThrough(ReserveList::class, JournalIssue::class, $this->primaryKey, 'j_issue_id');
    }

    /**
     * @return HasManyThrough
     */
    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(Item::class, JournalIssue::class, $this->primaryKey, 'j_issue_id');
    }
}
