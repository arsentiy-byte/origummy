<?php

declare(strict_types=1);

namespace App\Models\Acquisition;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Supplier.
 * @property int $supplier_id
 * @property string $supplier_name
 * @property string $bin
 * @property string $commercial_name
 * @property string $address
 * @property-read Batch[] $batches
 */
final class Supplier extends BaseModel
{
    protected const ALIAS = 's';

    /**
     * @var string
     */
    protected $table = 'lib_suppliers';

    /**
     * @var string
     */
    protected $primaryKey = 'supplier_id';

    /**
     * @var string[]
     */
    protected $fillable = ['supplier_name', 'bin/inn', 'commercial_name', 'address'];

    /**
     * @return HasMany
     */
    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class, 'supplier_id');
    }
}
