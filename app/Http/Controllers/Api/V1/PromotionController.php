<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\DTO\Promotion\UpdatePromotionDTO;
use App\Filters\PromotionFilter;
use App\Handlers\Promotion\CreatePromotion\CreatePromotionHandler;
use App\Handlers\Promotion\DeletePromotion\DeletePromotionHandler;
use App\Handlers\Promotion\UpdatePromotion\UpdatePromotionHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionCreateRequest;
use App\Http\Requests\PromotionUpdateRequest;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion\Promotion;
use App\Models\Promotion\PromotionType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class PromotionController.
 */
final class PromotionController extends Controller
{
    /**
     * @OA\GET (
     *      path="/v1/promotions",
     *      operationId="getPromotions",
     *      tags={"v1", "admin", "promotion"},
     *      summary="Список акций",
     *      description="Список акций",
     *      @OA\Response(response=200, description="Успешно получены"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @param PromotionFilter $filters
     * @return JsonResponse
     */
    public function getPromotions(Request $request, PromotionFilter $filters): JsonResponse
    {
        $promotions = Promotion::filter($filters)
            ->orderBy('id')
            ->paginate($request->get('limit', 10));

        return $this->response('Успешно получены', [
            'items' => PromotionResource::collection($promotions),
            'pagination' => [
                'total_pages' => $promotions->lastPage(),
                'total_items' => $promotions->total(),
                'current_page' => $promotions->currentPage(),
                'limit' => $promotions->perPage(),
            ],
        ]);
    }

    /**
     * @OA\Get (
     *      path="/v1/promotions/search",
     *      operationId="promotionSearch",
     *      tags={"v1", "admin", "promotion"},
     *      summary="Поиск по названию акций",
     *      description="Поиск по названию акций",
     *      parameters={
     *        {"name": "search","in":"query","type":"string","required":true,"description":"Value"},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Успешно получены",
     *          @OA\JsonContent(ref="#/components/schemas/PromotionResource"),
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function promotionSearch(Request $request): JsonResponse
    {
        $promotions = Promotion::where('title', 'ilike', '%'.$request->get('search').'%')->get();

        return $this->response('Успешно получены', PromotionResource::collection($promotions));
    }

    /**
     * @OA\GET (
     *      path="/v1/promotions/{promotion}",
     *      operationId="getPromotionById",
     *      tags={"v1", "admin", "promotion"},
     *      summary="Получить акцию по ID",
     *      description="Получить акцию по ID",
     *      @OA\Response(
     *          response=200,
     *          description="Данные по акций",
     *          @OA\JsonContent(ref="#/components/schemas/PromotionResource")
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Promotion $promotion
     * @return JsonResponse
     */
    public function getPromotionById(Promotion $promotion): JsonResponse
    {
        return $this->response('Данные по акций', new PromotionResource($promotion));
    }

    /**
     * @OA\GET (
     *      path="/v1/promotions/types",
     *      operationId="getPromotionTypes",
     *      tags={"v1", "admin", "promotion"},
     *      summary="Получить типы акций",
     *      description="Получить типы акций",
     *      @OA\Response(
     *          response=200,
     *          description="Успешно получены",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @return JsonResponse
     */
    public function getPromotionTypes(): JsonResponse
    {
        return $this->response('Успешно получены', PromotionType::all());
    }

    /**
     * @OA\Post (
     *      path="/v1/promotions",
     *      operationId="createPromotion",
     *      tags={"v1", "admin", "promotion"},
     *      summary="Создать акцию",
     *      description="Создать акцию",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/PromotionCreateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Акция успешно создана"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param PromotionCreateRequest $request
     * @param CreatePromotionHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function createPromotion(PromotionCreateRequest $request, CreatePromotionHandler $handler): JsonResponse
    {
        $handler->handle($request->getDto());

        return $this->response('Акция успешно создана');
    }

    /**
     * @OA\Put (
     *      path="/v1/promotions/{promotion}",
     *      operationId="updatePromotion",
     *      tags={"v1", "admin", "promotion"},
     *      summary="Изменить акцию",
     *      description="Изменить акцию",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/PromotionUpdateRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Акция успешно изменена",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Promotion $promotion
     * @param PromotionUpdateRequest $request
     * @param UpdatePromotionHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function updatePromotion(Promotion $promotion, PromotionUpdateRequest $request, UpdatePromotionHandler $handler): JsonResponse
    {
        $handler->handle($request->getDto($promotion->id));

        return $this->response('Акция успешно изменена');
    }

    /**
     * @OA\Delete  (
     *      path="/v1/promotions/{promotion}",
     *      operationId="deletePromotion",
     *      tags={"v1", "admin", "promotion"},
     *      summary="Удалить акцию",
     *      description="Удалить акцию",
     *      @OA\Response(
     *          response=200,
     *          description="Акция успешно удалена",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Promotion $promotion
     * @param DeletePromotionHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function deletePromotion(Promotion $promotion, DeletePromotionHandler $handler): JsonResponse
    {
        $handler->handle(UpdatePromotionDTO::fromArray(['promotion_id' => $promotion->id]));

        return $this->response('Акция успешно удалена');
    }
}
