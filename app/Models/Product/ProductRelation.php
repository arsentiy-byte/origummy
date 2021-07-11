<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Models\BaseModel;

/**
 * Class ProductRelation.
 * @property int $main_product_id
 * @property int $related_product_id
 */
final class ProductRelation extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'products_relations';

    /**
     * @var string[]
     */
    protected $fillable = [
        'main_product_id', 'related_product_id',
    ];
}
