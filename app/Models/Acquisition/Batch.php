<?php

declare(strict_types=1);

namespace App\Models\Acquisition;

use App\Models\BaseModel;
use App\Models\User\Employee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Batch.
 * @property int $hesab_id
 * @property string $title
 * @property string $create_date
 * @property int $supplier_id
 * @property string $invoice_date
 * @property string $supply_type
 * @property int $items_no
 * @property int $titles_no
 * @property int $doc_no
 * @property int $contract_no
 * @property string $invoice_details
 * @property int $cost
 * @property string $edit_date
 * @property-read BatchStatus|string $status
 * @property-read Employee $created_by
 * @property-read Employee $edited_by
 * @property-read SupplyType $supplyType
 * @property-read SupplyType $supplier
 */
final class Batch extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'lib_hesablar';

    /**
     * @var string
     */
    protected $primaryKey = 'hesab_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title', 'create_date', 'status', 'supplier_id', 'invoice_date', 'supply_type', 'items_no',
        'titles_no', 'doc_no', 'contract_no', 'invoice_details', 'cost', 'edited_by', 'edit_date', 'user_id',
    ];

    /**
     * решить!!!
     *
     * @return BelongsTo
     */
    public function supplyType(): BelongsTo
    {
        return $this->belongsTo(SupplyType::class, 'supply_type');
    }

    /**
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(BatchStatus::class, 'status');
    }

    /**
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function editedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'edited_by');
    }
}
