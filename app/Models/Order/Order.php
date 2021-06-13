<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Models\BaseModel;
use App\Models\Client;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Order.
 * @property int $id
 * @property string|null $additional_info
 * @property int $count
 * @property string $payment_type
 * @property string $delivery_time
 * @property string|null $delivery_type
 * @property int $client_id
 * @property-read Product[] $products
 * @property-read Client $client
 */
final class Order extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'additional_info', 'count', 'payment_type',
        'delivery_time', 'delivery_type', 'client_id',
    ];

    /**
     * @return HasManyThrough
     */
    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, OrderProduct::class, 'order_id', 'id', 'id', 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
