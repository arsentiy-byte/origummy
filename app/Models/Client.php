<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Client.
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $device_info
 * @property-read Order[] $orders
 * @method static Client firstOrNew(array $array)
 */
final class Client extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'phone', 'address', 'device_info',
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'client_id');
    }
}
