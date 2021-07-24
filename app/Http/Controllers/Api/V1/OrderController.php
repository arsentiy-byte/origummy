<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Filters\OrderFilter;
use App\Handlers\Order\OrderHandler;
use App\Handlers\Order\OrderParam;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Client;
use App\Models\Order\Order;
use App\Services\Notifications\Telegram\NotificationAfterOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class OrderController.
 */
final class OrderController extends Controller
{
    /**
     * @OA\Post (
     *      path="/v1/order",
     *      operationId="order",
     *      tags={"v1", "visualization"},
     *      summary="Оформить заказ",
     *      description="Оформить заказ",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/OrderRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Заказ успешно оформлен"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param OrderRequest $request
     * @param OrderHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function order(OrderRequest $request, OrderHandler $handler): JsonResponse
    {
        $orderParam = new OrderParam($request->getDto());
        $result = $handler->handle($orderParam);

        NotificationAfterOrder::send($result);

        return $this->response('Заказ успешно оформлен', [
            'user_phone' => $result['phone'],
        ]);
    }

    /**
     * @OA\GET (
     *      path="/v1/orders",
     *      operationId="getOrders",
     *      tags={"v1", "admin", "order"},
     *      summary="Список заказов",
     *      description="Список заказов",
     *      @OA\Response(response=200, description="Успешно получены"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @param OrderFilter $filters
     * @return JsonResponse
     */
    public function getOrders(Request $request, OrderFilter $filters): JsonResponse
    {
        $orderBy = $request->get('order_by', 'id');
        $orderDirection = $request->get('order_direction', 'desc');

        $duration = [
            'from_date' => $request->get('from_date'),
            'to_date'   => $request->get('to_date', now()),
        ];

        $ordersBuilder = Order::filter($filters);

        if (! is_null($duration['from_date'])) {
            $ordersBuilder = $ordersBuilder->where('created_at', '>=', $duration['from_date']);
        }

        $ordersBuilder = $ordersBuilder->where('created_at', '<=', $duration['to_date']);

        $orders = $ordersBuilder->orderBy($orderBy, $orderDirection)->paginate($request->get('limit', 10));

        return $this->response('Успешно получены', [
            'items' => OrderResource::collection($orders),
            'pagination' => [
                'total_pages' => $orders->lastPage(),
                'total_items' => $orders->total(),
                'current_page' => $orders->currentPage(),
                'limit' => $orders->perPage(),
            ],
        ]);
    }

    /**
     * @OA\GET (
     *      path="/v1/orders/{order}",
     *      operationId="getOrderById",
     *      tags={"v1", "admin", "order"},
     *      summary="Получить заказ по ID",
     *      description="Получить заказ по ID",
     *      @OA\Response(
     *          response=200,
     *          description="Данные по категорий",
     *          @OA\JsonContent(ref="#/components/schemas/OrderResource")
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Order $order
     * @return JsonResponse
     */
    public function getOrderById(Order $order): JsonResponse
    {
        return $this->response('Данные по заказу', new OrderResource($order));
    }

    /**
     * @OA\GET (
     *      path="/v1/orders/by_client/{client}",
     *      operationId="getOrderByClient",
     *      tags={"v1", "admin", "order"},
     *      summary="Получить заказы клиента",
     *      description="Получить заказы клиента",
     *      @OA\Response(
     *          response=200,
     *          description="Успешно получены",
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @param Client $client
     * @return JsonResponse
     */
    public function getOrderByClient(Request $request, Client $client): JsonResponse
    {
        $orders = Order::where('client_id', $client->id)
            ->orderBy('id', 'desc')
            ->paginate($request->get('limit', 10));

        return $this->response('Успешно получены', [
            'items' => OrderResource::collection($orders),
            'pagination' => [
                'total_pages' => $orders->lastPage(),
                'total_items' => $orders->total(),
                'current_page' => $orders->currentPage(),
                'limit' => $orders->perPage(),
            ],
        ]);
    }
}
