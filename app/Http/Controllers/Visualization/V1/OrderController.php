<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visualization\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Client;
use App\Models\Order\Order;
use Illuminate\Http\JsonResponse;

/**
 * Class OrderController.
 */
final class OrderController extends Controller
{
    /**
     * @OA\GET (
     *      path="/web/v1/orders/by_client/{phone}",
     *      operationId="getClientOrders",
     *      tags={"v1", "order", "web"},
     *      summary="Список заказов клиента",
     *      description="Список заказов клиента",
     *      @OA\Response(response=200, description="Список заказов клиента"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param string $phone
     * @return JsonResponse
     */
    public function getClientOrders(string $phone): JsonResponse
    {
        $client = Client::where('phone', $phone)->firstOrFail();

        $orders = Order::where('client_id', $client->id)->get();

        return $this->response('Список заказов клиента', OrderResource::collection($orders));
    }
}
