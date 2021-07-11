<?php

declare(strict_types=1);

namespace App\Models\Promotion;

use App\Models\BaseModel;

/**
 * Class RelatedPromotion.
 * @property int $promotion_id
 * @property int $product_id
 */
final class RelatedPromotion extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'related_promotions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'promotion_id', 'product_id',
    ];
}
