<?php

declare(strict_types=1);

namespace App\Models\Promotion;

use App\Models\BaseModel;

/**
 * Class PromotionType.
 * @property string $name
 * @property string $description
 */
final class PromotionType extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'promotions_types';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'description',
    ];
}
