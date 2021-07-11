<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\OrderDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     required={"name", "phone", "address", "payment_type", "delivery_time", "products"},
 *      @OA\Property(
 *         property="name",
 *         type="string"
 *      ),
 *     @OA\Property(
 *         property="phone",
 *         type="string"
 *      ),
 *     @OA\Property(
 *         property="address",
 *         type="string"
 *      ),
 *     @OA\Property(
 *         property="additional_info",
 *         type="string"
 *      ),
 *     @OA\Property(
 *         property="count",
 *         type="integer"
 *      ),
 *     @OA\Property(
 *         property="payment_type",
 *         type="string"
 *      ),
 *     @OA\Property(
 *         property="delivery_time",
 *         type="string"
 *      ),
 *      @OA\Property(
 *         property="products",
 *         type="array",
 *         @OA\Items(type="object")
 *      ),
 * )
 * Class OrderRequest
 */
final class OrderRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'additional_info' => 'nullable|string',
            'count' => 'nullable|int',
            'payment_type' => 'required|string',
            'delivery_time' => 'required|string',
            'products' => 'required|array',
            'products.*' => 'array:id,count',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'device_info' => $this->server('HTTP_USER_AGENT'),
        ]);
    }

    /**
     * @return OrderDTO
     */
    public function getDto(): OrderDTO
    {
        return OrderDTO::fromArray($this->toArray());
    }
}
