<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Category\CategoryDTO;
use App\Filters\CategoryFilter;
use App\Handlers\Category\CreateCategory\CreateCategoryHandler;
use App\Handlers\Category\DeleteCategory\DeleteCategoryHandler;
use App\Handlers\Category\UpdateCategory\UpdateCategoryHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class CategoryController.
 */
final class CategoryController extends Controller
{
    /**
     * @OA\GET (
     *      path="/v1/categories",
     *      operationId="getCategories",
     *      tags={"v1", "admin", "category"},
     *      summary="Список категорий",
     *      description="Список категорий",
     *      @OA\Response(response=200, description="Успешно получены"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @param CategoryFilter $filters
     * @return JsonResponse
     */
    public function getCategories(Request $request, CategoryFilter $filters): JsonResponse
    {
        $categories = Category::filter($filters)
            ->orderBy('id')
            ->paginate($request->get('limit', 10));

        return $this->response('Успешно получены', [
            'items' => CategoryResource::collection($categories),
            'pagination' => [
                'total_pages' => $categories->lastPage(),
                'total_items' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'limit' => $categories->perPage(),
            ],
        ]);
    }

    /**
     * @OA\Get (
     *      path="/v1/categories/search",
     *      operationId="categorySearch",
     *      tags={"v1", "admin", "category"},
     *      summary="Поиск по названию категорий",
     *      description="Поиск по названию категорий",
     *      parameters={
     *        {"name": "search","in":"query","type":"string","required":true,"description":"Value"},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Успешно получены",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource"),
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function categorySearch(Request $request): JsonResponse
    {
        $categories = Category::where('title', 'ilike', '%'.$request->get('search').'%')->get();

        return $this->response('Успешно получены', CategoryResource::collection($categories));
    }

    /**
     * @OA\GET (
     *      path="/v1/categories/{category}",
     *      operationId="getCategoryById",
     *      tags={"v1", "admin", "category"},
     *      summary="Получить категорию по ID",
     *      description="Получить категорию по ID",
     *      @OA\Response(
     *          response=200,
     *          description="Данные по категорий",
     *          @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Category $category
     * @return JsonResponse
     */
    public function getCategoryById(Category $category): JsonResponse
    {
        return $this->response('Данные по категорий', new CategoryResource($category));
    }

    /**
     * @OA\Post (
     *      path="/v1/categories",
     *      operationId="createCategory",
     *      tags={"v1", "admin", "category"},
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
     *      tags={"v1", "admin", "category"},
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

    /**
     * @OA\Delete  (
     *      path="/v1/categories/{category}",
     *      operationId="deleteCategory",
     *      tags={"v1", "admin", "category"},
     *      summary="Удалить категорию",
     *      description="Удалить категорию",
     *      @OA\Response(
     *          response=200,
     *          description="Категория успешно удалена",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Category $category
     * @param DeleteCategoryHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function deleteCategory(Category $category, DeleteCategoryHandler $handler): JsonResponse
    {
        $categoryDTO = CategoryDTO::fromArray(['category_id' => $category->id]);
        $handler->handle($categoryDTO);

        return $this->response('Категория успешно удалена');
    }
}
