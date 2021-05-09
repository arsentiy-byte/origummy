<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\Category\CategoryDTO;

/**
 * @OA\Schema(
 *     required={"title", "images"},
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
 * )
 * Class CategoryCreateRequest
 */
final class CategoryCreateRequest extends FormRequest
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
            'parent_id' => 'nullable|integer',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg',
        ];
    }

    public function getDto(): CategoryDTO
    {
        return CategoryDTO::fromArray(array_merge($this->toArray(), ['images' => $this->allFiles()['images']]));
    }
}
