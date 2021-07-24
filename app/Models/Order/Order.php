<?php

declare(strict_types=1);

namespace App\Models\Order;

use App\Models\BaseModel;
use App\Models\Client;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read Collection|Product[] $products
 * @property-read Collection $orderProducts
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
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'orders_products')->using(OrderProduct::class)->withPivot('count');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
