<?php

declare(strict_types=1);

namespace App\Models\Acquisition;

use App\Models\BaseModel;

/**
 * Class SupplyType.
 * @property string $key
 * @property string $title_en
 * @property string $title_ru
 * @property string $title_kz
 */
final class SupplyType extends BaseModel
{
    protected const ALIAS = 'st';

    /**
     * @var string
     */
    protected $table = 'lib_supply_types';

    /**
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title_en', 'title_ru', 'title_kz',
    ];
}
