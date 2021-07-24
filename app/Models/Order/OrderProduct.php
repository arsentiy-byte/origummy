<?php

declare(strict_types=1);

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class OrderProduct.
 * @property int $order_id
 * @property int $product_id
 * @property int $count
 */
final class OrderProduct extends Pivot
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
