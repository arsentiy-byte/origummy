<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Models\BaseModel;

/**
 * Class OrderProduct.
 * @property int $order_id
 * @property int $product_id
 * @property int $count
 */
final class OrderProduct extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'orders_products';

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id', 'product_id', 'count',
    ];
}
