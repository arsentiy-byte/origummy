<?php

declare(strict_types=1);

namespace App\Models\Acquisition;

use App\Models\BaseModel;
use App\Models\Materials\Book;
use App\Models\Materials\Disc;
use App\Models\Materials\Journal;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Publisher.
 * @property int $publisher_id
 * @property string $name
 * @property string $commercial_name
 * @property string $address
 * @property-read Book[] $books
 * @property-read Journal[] $journals
 * @property-read Disc[] $discs
 */
final class Publisher extends BaseModel
{
    protected const ALIAS = 'p';

    /**
     * @var string
     */
    protected $table = 'lib_publishers';

    /**
     * @var string
     */
    protected $primaryKey = 'publisher_id';

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'commercial_name', 'address'];

    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'publisher_id');
    }

    /**
     * @return HasMany
     */
    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class, 'publisher_id');
    }

    /**
     * @return HasMany
     */
    public function discs(): HasMany
    {
        return $this->hasMany(Disc::class, 'publisher_id');
    }
}
