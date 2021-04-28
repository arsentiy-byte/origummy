<?php

declare(strict_types=1);

namespace App\Models\Materials;

use App\Models\Acquisition\Item;
use App\Models\Acquisition\Publisher;
use App\Models\BaseModel;
use App\Traits\Materials\MaterialAdditionalAttributes;
use App\Traits\Materials\MaterialRelationships;

/**
 * Class Disc.
 * @property int $disc_id
 * @property string $name
 * @property string $isbn
 * @property string $issn
 * @property int $publisher_id
 * @property int $pub_year
 * @property string $pub_city
 * @property int $old_id
 * @property string $parallel_title
 * @property string $pub_info
 * @property int $issue_number
 * @property string $issue_date
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
final class Disc extends BaseModel
{
    use MaterialRelationships, MaterialAdditionalAttributes;

    protected const ALIAS = 'd';

    /**
     * @var string
     */
    protected $table = 'lib_discs';

    /**
     * @var string
     */
    protected $primaryKey = 'disc_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'isbn',
        'issn',
        'publisher_id',
        'pub_year',
        'pub_city',
        'old_id',
        'parallel_title',
        'pub_info',
        'issue_number',
        'issue_date',
        'language',
        'type',
    ];

    /**
     * @return string|null
     */
    public function getIssnAttribute(): ?string
    {
        return $this->issn;
    }
}
