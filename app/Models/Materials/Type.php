<?php

declare(strict_types=1);

namespace App\Models\Materials;

use App\Models\BaseModel;

/**
 * Class Type.
 * @property string $key
 * @property string $title_en
 * @property string $title_ru
 * @property string $title_kz
 * @property string $description
 */
final class Type extends BaseModel
{
    protected const ALIAS = 't';

    /**
     * @var string
     */
    protected $table = 'lib_material_types';

    /**
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = ['key', 'title_en', 'title_ru', 'title_kz', 'description'];
}
