<?php

declare(strict_types=1);

namespace App\Models\Promotion;

use App\Models\BaseModel;

/**
 * Class ProductPromotion.
 * @property int $product_id
 * @property int $promotion_id
 */
final class ProductPromotion extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'products_promotions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'product_id', 'promotion_id',
    ];
}
