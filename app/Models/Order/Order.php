<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Models\BaseModel;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Order.
 * @property string $name
 * @property string $phone
 * @property string $device_info
 * @property string $address
 * @property string|null $additional_info
 * @property int|null $count
 * @property string $payment_type
 * @property-read Product[] $products
 */
final class Order extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'phone', 'device_info', 'address', 'additional_info', 'count', 'payment_type',
    ];

    /**
     * @return HasManyThrough
     */
    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, OrderGood::class, 'order_id', 'product_id');
    }
}
