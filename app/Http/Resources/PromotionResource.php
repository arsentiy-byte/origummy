<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Promotion\Promotion;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema (
 *     @OA\Property (
 *          property="id",
 *          type="integer"
 *     ),
 *     @OA\Property (
 *          property="title",
 *          type="string"
 *     ),
 *     @OA\Property (
 *          property="description",
 *          type="string"
 *     ),
 *     @OA\Property (
 *          property="status",
 *          type="boolean"
 *     ),
 *     @OA\Property (
 *          property="type_id",
 *          type="integer"
 *     ),
 *     @OA\Property (
 *          property="type",
 *          type="object"
 *     ),
 *     @OA\Property (
 *          property="relatedProducts",
 *          type="array",
 *          @OA\Items(
 *              type="object"
 *          )
 *     ),
 *     @OA\Property (
 *          property="products",
 *          type="array",
 *          @OA\Items(
 *              type="object"
 *          )
 *     ),
 * )
 * Class PromotionResource
 * @mixin Promotion
 */
final class PromotionResource extends JsonResource
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
            'id'                => $this->id,
            'title'             => $this->title,
            'description'       => $this->description ?? '',
            'status'            => $this->status,
            'type_id'           => $this->type_id,
            'type'              => $this->type,
            'related_products'  => $this->relatedProducts ?? [],
            'products'          => $this->products ?? [],
        ];
    }
}
