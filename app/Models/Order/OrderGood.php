<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Models\BaseModel;

/**
 * Class OrderGood.
 * @property int $order_id
 * @property int $product_id
 */
final class OrderGood extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'orders_goods';

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id', 'product_id',
    ];
}
