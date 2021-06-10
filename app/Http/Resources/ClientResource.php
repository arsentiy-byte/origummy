<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Client;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     @OA\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *     @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="phone",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="address",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="device_info",
 *          type="string"
 *      ),
 * )
 * Class ClientResource
 * @mixin Client
 */
final class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'device_info'   => $this->device_info,
        ];
    }
}
