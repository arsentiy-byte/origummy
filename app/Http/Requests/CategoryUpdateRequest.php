<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\Category\CategoryDTO;

/**
 * @OA\Schema(
 *     required={"title"},
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
 *      @OA\Property(
 *         property="parent_id",
 *         type="integer"
 *      ),
 *      @OA\Property(
 *         property="images",
 *         type="array",
 *         description="files:jpeg,png,jpg,svg",
 *         @OA\Items(type="image")
 *      ),
 *      @OA\Property(
 *         property="delete_images",
 *         type="array",
 *         description="file paths",
 *         @OA\Items(type="string")
 *      ),
 * )
 * Class CategoryUpdateRequest
 */
final class CategoryUpdateRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
            'is_default' => 'nullable|boolean',
            'parent_id' => 'nullable|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'string',
        ];
    }

    public function getDto(): CategoryDTO
    {
        $images = $this->has('images') ? $this->allFiles()['images'] : null;

        return CategoryDTO::fromArray(array_merge($this->toArray(), ['images' => $images]));
    }
}
