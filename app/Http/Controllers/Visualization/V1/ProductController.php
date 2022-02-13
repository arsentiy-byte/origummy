<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visualization\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Promotion\ProductPromotion;
use Illuminate\Http\JsonResponse;

/**
 * Class ProductController.
 */
final class ProductController extends Controller
{
    /**
     * @OA\GET (
     *      path="/web/v1/products/by_category/{category_slug}",
     *      operationId="getProductsByCategorySlug",
     *      tags={"v1", "web", "product"},
     *      summary="Получить товары по категорий",
     *      description="Получить товары по категорий",
     *      @OA\Response(
     *          response=200,
     *          description="Товары по категорий",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param string $slug
     * @return JsonResponse
     */
    public function getProductsByCategorySlug(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('status', true)
            ->orderBy('price')
            ->get();

        return $this->response('Товары по категорий', ProductResource::collection($products));
    }

    /**
     * @OA\GET (
     *      path="/web/v1/products/with/promotions",
     *      operationId="getProductsWithPromotions",
     *      tags={"v1", "web", "product"},
     *      summary="Получить товары с акциями",
     *      description="Получить товары с акциями",
     *      @OA\Response(
     *          response=200,
     *          description="Подарки и скидки",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @return JsonResponse
     */
    public function getProductsWithPromotions(): JsonResponse
    {
        $productIds = ProductPromotion::distinct('product_id')->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->orderBy('price')->get();
        return $this->response('Подарки и скидки', ProductResource::collection($products));
    }
}
