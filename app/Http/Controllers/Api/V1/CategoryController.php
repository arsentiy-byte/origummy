<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Handlers\CreateCategory\CreateCategoryHandler;
use App\Handlers\UpdateCategory\UpdateCategoryHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category\Category;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Class CategoryController.
 */
final class CategoryController extends Controller
{
    /**
     * @OA\Post (
     *      path="/v1/categories",
     *      operationId="createCategory",
     *      tags={"v1", "admin"},
     *      summary="Создать категорию",
     *      description="Создать категорию",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/CategoryCreateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Категория успешно создана"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param CategoryCreateRequest $request
     * @param CreateCategoryHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function createCategory(CategoryCreateRequest $request, CreateCategoryHandler $handler): JsonResponse
    {
        $handler->handle($request->getDto());

        return $this->response('Категория успешно создана');
    }

    /**
     * @OA\Put (
     *      path="/v1/categories/{category}",
     *      operationId="updateCategory",
     *      tags={"v1", "admin"},
     *      summary="Изменить категорию",
     *      description="Изменить категорию",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/CategoryUpdateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Категория успешно изменена",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Category $category
     * @param CategoryUpdateRequest $request
     * @param UpdateCategoryHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function updateCategory(Category $category, CategoryUpdateRequest $request, UpdateCategoryHandler $handler): JsonResponse
    {
        $categoryDTO = $request->getDto();
        $categoryDTO->categoryID = $category->id;
        $handler->handle($categoryDTO);

        return $this->response('Категория успешно изменена');
    }
}
