<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visualization\V1;

use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use Illuminate\Http\JsonResponse;

final class CategoryController extends Controller
{
    /**
     * @OA\GET (
     *      path="/web/v1/categories/main_page",
     *      operationId="getCategoriesAtMainPage",
     *      tags={"v1", "category", "web"},
     *      summary="Список категорий в главной странице",
     *      description="Список категорий в главной странице",
     *      @OA\Response(response=200, description="Категории в главной странице"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @return JsonResponse
     */
    public function getCategoriesAtMainPage(): JsonResponse
    {
        $categories = Category::query()
            ->with('images')
            ->select('id', 'title', 'slug')
            ->where('status', true)
            ->get()
            ->toArray();

        return $this->response('Категории в главной странице', $categories);
    }

    /**
     * @OA\GET (
     *      path="/web/v1/categories/menu",
     *      operationId="getCategoriesAtMenu",
     *      tags={"v1", "category", "web"},
     *      summary="Список категорий в меню",
     *      description="Список категорий в меню",
     *      @OA\Response(response=200, description="Категории в меню"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @return JsonResponse
     */
    public function getCategoriesAtMenu(): JsonResponse
    {
        $categories = Category::query()
            ->select('id', 'title', 'slug')
            ->where('status', true)
            ->get()
            ->toArray();

        return $this->response('Категории в меню', $categories);
    }
}
