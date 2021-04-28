<?php

declare(strict_types=1);

namespace App\Models\Acquisition;

use App\Models\BaseModel;
use App\Models\Materials\Book;
use App\Models\Materials\Disc;
use App\Models\Materials\Journal;
use App\Models\Materials\JournalIssue;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Item.
 * @property int $inv_id
 * @property int $book_id
 * @property int $j_issue_id
 * @property int $disc_id
 * @property string $receive_date
 * @property int $oda_id
 * @property int $status
 * @property string $old_inv_id
 * @property int $hesab_id
 * @property int $emeliyyat_no
 * @property int $price
 * @property string $currency
 * @property int $barcode
 * @property string $sigle_type
 * @property string $user_cid
 * @property string $user_name
 * @property string $edited_by
 * @property-read Book $book
 * @property-read Disc $disc
 * @property-read Journal $journal
 */
final class Item extends BaseModel
{
    protected const ALIAS = 'i';

    /**
     * @var string
     */
    protected $table = 'lib_inventory';

    /**
     * @var string
     */
    protected $primaryKey = 'inv_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'book_id',
        'j_issue_id',
        'disc_id',
        'receive_date',
        'oda_id',
        'status',
        'old_inv_id',
        'hesab_id',
        'emeliyyat_no',
        'price',
        'currency',
        'barcode',
        'sigle_type',
        'user_cid',
        'user_name',
        'edited_by',
    ];

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
    public function disc(): BelongsTo
    {
        return $this->belongsTo(Disc::class, 'disc_id');
    }

    /**
     * @return BelongsTo
     */
    public function journalIssue(): BelongsTo
    {
        return $this->belongsTo(JournalIssue::class, 'j_issue_id');
    }
}
