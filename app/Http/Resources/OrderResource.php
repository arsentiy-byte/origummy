<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Order\Order;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;

/**
 * @OA\Schema(
 *     @OA\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *     @OA\Property(
 *          property="client_id",
 *          type="integer"
 *      ),
 *     @OA\Property(
 *          property="client_name",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="client_phone",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="payment_type",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="delivery_time",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="order_count",
 *          type="integer"
 *      ),
 *     @OA\Property(
 *          property="total_price",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="date",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="additional_info",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="products",
 *          type="array",
 *          @OA\Items(
 *              type="Object"
 *          )
 *      ),
 * )
 * Class OrderResource
 * @mixin Order
 */
final class OrderResource extends JsonResource
{
    use OrderTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[Pure]
 public function toArray($request): array
 {
     return [
            'id'                => $this->id,
            'client_id'         => $this->client_id,
            'client_name'       => $this->client->name,
            'client_phone'      => $this->client->phone,
            'payment_type'      => $this->payment_type,
            'delivery_time'     => $this->delivery_time,
            'order_count'       => $this->count,
            'total_price'       => $this->getTotalPrice($this->products->toArray()).' тг.',
            'date'              => $this->created_at,
            'additional_info'   => $this->additional_info,
            'products'          => $this->products,
        ];
 }
}
