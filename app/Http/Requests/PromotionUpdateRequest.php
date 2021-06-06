<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\Promotion\UpdatePromotionDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema (
 *     required={"id", "type_id"},
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
 *          property="related_products",
 *          type="array",
 *          @OA\Items(
 *              type="integer"
 *          )
 *     ),
 *     @OA\Property (
 *          property="delete_related_products",
 *          type="array",
 *          @OA\Items(
 *              type="integer"
 *          )
 *     ),
 * )
 * Class PromotionUpdateRequest
 */
final class PromotionUpdateRequest extends FormRequest
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
            'title'                     => 'required|string',
            'description'               => 'nullable|string',
            'status'                    => 'nullable|boolean',
            'type_id'                   => 'required|integer',
            'related_products'          => 'nullable|array',
            'related_products.*'        => 'integer',
            'delete_related_products'   => 'nullable|array',
            'delete_related_products.*' => 'integer',
        ];
    }

    /**
     * @param int $promotionId
     * @return UpdatePromotionDTO
     */
    public function getDto(int $promotionId): UpdatePromotionDTO
    {
        return UpdatePromotionDTO::fromArray(array_merge($this->toArray(), ['promotion_id' => $promotionId]));
    }
}
