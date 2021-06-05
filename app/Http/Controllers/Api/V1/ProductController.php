<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Product\UpdateProductDTO;
use App\Filters\ProductFilter;
use App\Handlers\Product\CreateProduct\CreateProductHandler;
use App\Handlers\Product\DeleteProduct\DeleteProductHandler;
use App\Handlers\Product\UpdateProduct\UpdateProductHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category\Category;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class ProductController.
 */
final class ProductController extends Controller
{
    /**
     * @OA\GET (
     *      path="/v1/products",
     *      operationId="getProducts",
     *      tags={"v1", "admin"},
     *      summary="Список товаров",
     *      description="Список товаров",
     *      @OA\Response(response=200, description="Успешно получены"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @param ProductFilter $filters
     * @return JsonResponse
     */
    public function getProducts(Request $request, ProductFilter $filters): JsonResponse
    {
        $products = Product::filter($filters)
            ->orderBy('id')
            ->paginate($request->get('limit', 10));

        return $this->response('Успешно получены', [
            'items' => ProductResource::collection($products),
            'pagination' => [
                'total_pages' => $products->lastPage(),
                'total_items' => $products->total(),
                'current_page' => $products->currentPage(),
                'limit' => $products->perPage(),
            ],
        ]);
    }

    /**
     * @OA\Get (
     *      path="/v1/products/search",
     *      operationId="productSearch",
     *      tags={"v1", "admin"},
     *      summary="Поиск по названию товара",
     *      description="Поиск по названию товара",
     *      parameters={
     *        {"name": "search","in":"query","type":"string","required":true,"description":"Value"},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Успешно получены",
     *          @OA\JsonContent(ref="#/components/schemas/ProductResource"),
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function productSearch(Request $request): JsonResponse
    {
        $products = Product::where('title', 'ilike', '%'.$request->get('search').'%')->get();

        return $this->response('Успешно получены', ProductResource::collection($products));
    }

    /**
     * @OA\GET (
     *      path="/v1/products/{product}",
     *      operationId="getProductById",
     *      tags={"v1", "admin"},
     *      summary="Получить товар по ID",
     *      description="Получить товар по ID",
     *      @OA\Response(
     *          response=200,
     *          description="Данные по товару",
     *          @OA\JsonContent(ref="#/components/schemas/ProductResource")
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Product $product
     * @return JsonResponse
     */
    public function getProductById(Product $product): JsonResponse
    {
        return $this->response('Данные по товару', new ProductResource($product));
    }

    /**
     * @OA\Post (
     *      path="/v1/products",
     *      operationId="createProduct",
     *      tags={"v1", "admin"},
     *      summary="Создать товар",
     *      description="Создать товар",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/ProductCreateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Товар успешно создан"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param ProductCreateRequest $request
     * @param CreateProductHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function createProduct(ProductCreateRequest $request, CreateProductHandler $handler): JsonResponse
    {
        $handler->handle($request->getDto());

        return $this->response('Товар успешно создан');
    }

    /**
     * @OA\Put (
     *      path="/v1/products/{product}",
     *      operationId="updateProduct",
     *      tags={"v1", "admin"},
     *      summary="Изменить товар",
     *      description="Изменить товар",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/ProductUpdateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Товар успешно изменен",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Product $product
     * @param ProductUpdateRequest $request
     * @param UpdateProductHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function updateProduct(Product $product, ProductUpdateRequest $request, UpdateProductHandler $handler): JsonResponse
    {
        $productDTO = $request->getDto($product->id);
        $handler->handle($productDTO);

        return $this->response('Товар успешно изменен');
    }

    /**
     * @OA\Delete  (
     *      path="/v1/products/{product}",
     *      operationId="deleteProduct",
     *      tags={"v1", "admin"},
     *      summary="Удалить товар",
     *      description="Удалить товар",
     *      @OA\Response(
     *          response=200,
     *          description="Товар успешно удален",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Product $product
     * @param DeleteProductHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function deleteProduct(Product $product, DeleteProductHandler $handler): JsonResponse
    {
        $productDTO = UpdateProductDTO::fromArray(['product_id' => $product->id]);
        $handler->handle($productDTO);

        return $this->response('Товар успешно удален');
    }

    /**
     * @OA\GET (
     *      path="/v1/products/{category}",
     *      operationId="getProductsByCategory",
     *      tags={"v1", "admin"},
     *      summary="Список товаров по категорию",
     *      description="Список товаров по категорию",
     *      @OA\Response(response=200, description="Успешно получены"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     */
    public function getProductsByCategory(Request $request, Category $category): JsonResponse
    {
        $products = Product::where('category_id', $category->id)
            ->orderBy('id')
            ->paginate($request->get('limit', 10));

        return $this->response('Успешно получены', [
            'items' => ProductResource::collection($products),
            'pagination' => [
                'total_pages' => $products->lastPage(),
                'total_items' => $products->total(),
                'current_page' => $products->currentPage(),
                'limit' => $products->perPage(),
            ],
        ]);
    }
}
