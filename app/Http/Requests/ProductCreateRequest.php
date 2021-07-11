<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\Product\ProductDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     required={"title", "price", "category_id", "images"},
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
 * )
 * Class ProductCreateRequest
 */
final class ProductCreateRequest extends FormRequest
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
            'title'             => 'required|string',
            'description'       => 'nullable|string',
            'status'            => 'nullable|boolean',
            'price'             => 'required|integer',
            'old_price'         => 'nullable|integer',
            'count'             => 'nullable|integer',
            'category_id'       => 'required|integer',
            'images'            => 'required|array',
            'images.*'          => 'image|mimes:jpeg,png,jpg,svg',
            'promotions'        => 'nullable|array',
            'promotions.*'      => 'integer',
            'related_products'  => 'nullable|array',
            'related_products.*'  => 'integer',
        ];
    }

    /**
     * @return ProductDTO
     */
    public function getDto(): ProductDTO
    {
        return ProductDTO::fromArray(array_merge($this->toArray(), ['images' => $this->allFiles()['images']]));
    }
}
