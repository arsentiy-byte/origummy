<?php

declare(strict_types=1);

namespace App\Models\Materials;

use App\Models\Acquisition\Item;
use App\Models\Acquisition\Publisher;
use App\Models\BaseModel;
use App\Traits\Materials\MaterialAdditionalAttributes;
use App\Traits\Materials\MaterialRelationships;
use Date;

/**
 * Class Book.
 * @property int $book_id
 * @property int $isbn
 * @property string $title
 * @property int $publisher_id
 * @property int $pub_year
 * @property string $pub_city
 * @property string $editor
 * @property string $translator
 * @property int $page_num
 * @property string $seriya
 * @property int $sureli
 * @property string $note
 * @property int $old_id
 * @property string $parallel_title
 * @property string $title_related_info
 * @property string $pub_info
 * @property int $issue_number
 * @property Date $issue_date
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
final class Book extends BaseModel
{
    use MaterialRelationships, MaterialAdditionalAttributes;

    protected const ALIAS = 'b';

    /**
     * @var string
     */
    protected $table = 'lib_books';

    /**
     * @var string
     */
    protected $primaryKey = 'book_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'isbn',
        'title',
        'publisher_id',
        'pub_year',
        'pub_city',
        'editor',
        'translator',
        'page_num',
        'seriya',
        'sureli',
        'note',
        'old_id',
        'parallel_title',
        'title_related_info',
        'pub_info',
        'issue_number',
        'issue_date',
        'language',
        'type',
    ];
}
