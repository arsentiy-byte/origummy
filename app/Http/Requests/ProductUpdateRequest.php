<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\Product\UpdateProductDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     required={"title", "price", "category_id"},
 *      @OA\Property(
 *         property="title",
 *         type="string"
 *      ),
 *      @OA\Property(
 *         property="description",
 *         type="string"
 *      ),
 *      @OA\Property(
 *         property="status",
 *         type="boolean"
 *      ),
 *     @OA\Property(
 *         property="price",
 *         type="integer"
 *      ),
 *     @OA\Property(
 *         property="old_price",
 *         type="integer"
 *      ),
 *     @OA\Property(
 *         property="count",
 *         type="integer"
 *      ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer"
 *      ),
 *      @OA\Property(
 *         property="images",
 *         type="array",
 *         description="files:jpeg,png,jpg,svg",
 *         @OA\Items(type="image")
 *      ),
 *     @OA\Property(
 *         property="promotions",
 *         type="array",
 *         description="promotion ids",
 *         @OA\Items(type="integer")
 *      ),
 *     @OA\Property(
 *         property="related_products",
 *         type="array",
 *         description="product ids",
 *         @OA\Items(type="integer")
 *      ),
 *     @OA\Property(
 *         property="delete_images",
 *         type="array",
 *         description="file paths",
 *         @OA\Items(type="string")
 *      ),
 *     @OA\Property(
 *         property="delete_promotions",
 *         type="array",
 *         description="promotion ids",
 *         @OA\Items(type="integer")
 *      ),
 *     @OA\Property(
 *         property="delete_related_products",
 *         type="array",
 *         description="product ids",
 *         @OA\Items(type="integer")
 *      ),
 * )
 * Class ProductUpdateRequest
 */
final class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'                     => 'nullable|string',
            'description'               => 'nullable|string',
            'status'                    => 'nullable|boolean',
            'price'                     => 'nullable|integer',
            'old_price'                 => 'nullable|integer',
            'count'                     => 'nullable|integer',
            'category_id'               => 'nullable|integer',
            'images'                    => 'nullable|array',
            'images.*'                  => 'image|mimes:jpeg,png,jpg,svg',
            'promotions'                => 'nullable|array',
            'promotions.*'              => 'integer',
            'related_products'          => 'nullable|array',
            'related_products.*'        => 'integer',
            'delete_images'             => 'nullable|array',
            'delete_images.*'           => 'string',
            'delete_related_products'   => 'nullable|array',
            'delete_related_products.*' => 'integer',
            'delete_promotions'         => 'nullable|array',
            'delete_promotions.*'       => 'integer',
        ];
    }

    /**
     * @param int $productId
     * @return UpdateProductDTO
     */
    public function getDto(int $productId): UpdateProductDTO
    {
        $images = $this->has('images') ? $this->allFiles()['images'] : null;

        return UpdateProductDTO::fromArray(array_merge($this->toArray(), ['product_id' => $productId, 'images' => $images]));
    }
}
