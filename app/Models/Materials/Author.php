<?php

declare(strict_types=1);

namespace App\Models\Materials;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Author.
 * @property int $book_author_id
 * @property int $book_id
 * @property string $name
 * @property string $surname
 * @property int $is_main
 * @property string $sign
 * @property string $temp_names
 * @property int $j_issue_id
 * @property int $disc_id
 * @property-read Book $book
 */
final class Author extends BaseModel
{
    protected const ALIAS = 'a';

    /**
     * @var string
     */
    protected $table = 'lib_book_authors';

    /**
     * @var string
     */
    protected $primaryKey = 'book_author_id';

    /**
     * @var string[]
     */
    protected $fillable = ['book_id', 'name', 'surname', 'is_main', 'sign', 'temp_names', 'j_issue_id', 'disc_id'];

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
