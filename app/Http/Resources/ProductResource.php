<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product\Product;
use Illuminate\Http\Request;
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
 *          property="price",
 *          type="integer"
 *     ),
 *     @OA\Property (
 *          property="old_price",
 *          type="integer"
 *     ),
 *     @OA\Property (
 *          property="count",
 *          type="integer"
 *     ),
 *     @OA\Property (
 *          property="category_id",
 *          type="integer"
 *     ),
 *     @OA\Property (
 *          property="status",
 *          type="boolean"
 *     ),
 *     @OA\Property (
 *          property="category",
 *          type="object"
 *     ),
 *     @OA\Property (
 *          property="promotions",
 *          type="array",
 *          @OA\Items(
 *              type="object"
 *          )
 *     ),
 *     @OA\Property (
 *          property="images",
 *          type="array",
 *          @OA\Items(
 *              type="object"
 *          )
 *     ),
 *     @OA\Property (
 *          property="relatedProducts",
 *          type="array",
 *          @OA\Items(
 *              type="object"
 *          )
 *     ),
 * )
 * Class ProductResource
 * @mixin Product
 */
final class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'description'       => $this->description,
            'price'             => $this->price,
            'old_price'         => $this->old_price,
            'count'             => $this->count,
            'category_id'       => $this->category_id,
            'status'            => $this->status,
            'category'          => $this->category,
            'promotions'        => $this->promotions ?? [],
            'images'            => $this->images ?? [],
            'related_products'  => $this->relatedProducts ?? [],
        ];
    }
}
