<?php

declare(strict_types=1);

namespace App\Models\Acquisition;

use App\Models\BaseModel;

/**
 * Class BatchStatus.
 * @property int $id
 * @property string $title_en
 * @property string $title_kz
 * @property string $title_ru
 */
final class BatchStatus extends BaseModel
{
    protected const ALIAS = 'bs';

    /**
     * @var string
     */
    protected $table = 'lib_batch_status';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title_en', 'title_kz', 'title_ru',
    ];
}
