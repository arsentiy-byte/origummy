<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Category\Category;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     @OA\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *     @OA\Property(
 *          property="title",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="description",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="slug",
 *          type="string"
 *      ),
 *     @OA\Property(
 *          property="status",
 *          type="boolean"
 *      ),
 *     @OA\Property(
 *          property="is_default",
 *          type="boolean"
 *      ),
 *     @OA\Property(
 *          property="parent_id",
 *          type="integer"
 *      ),
 *     @OA\Property(
 *          property="images",
 *          type="array",
 *          @OA\Items(
 *              type="Object"
 *          )
 *      ),
 *     @OA\Property(
 *          property="products",
 *          type="array",
 *          @OA\Items(
 *              type="Object"
 *          )
 *      ),
 *     @OA\Property(
 *          property="parent",
 *          type="Object"
 *      )
 * )
 * Class CategoryResource
 * @mixin Category
 */
final class CategoryResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'status' => $this->status,
            'is_default' => $this->is_default,
            'parent_id' => $this->parent_id,
            'images' => $this->images ?? [],
            'products' => $this->products ?? [],
            'parent' => $this->parent ?? null,
        ];
    }
}
