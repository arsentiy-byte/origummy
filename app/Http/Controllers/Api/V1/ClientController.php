<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ClientController.
 */
final class ClientController extends Controller
{
    /**
     * @OA\GET (
     *      path="/v1/clients",
     *      operationId="getClients",
     *      tags={"v1", "admin", "client"},
     *      summary="Список клиентов",
     *      description="Список клиентов",
     *      @OA\Response(response=200, description="Успешно получены"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function getClients(Request $request): JsonResponse
    {
        $orderBy = $request->get('order_by', 'id');
        $orderDirect = $request->get('order_direct', 'desc');

        $clients = Client::query()
            ->orderBy($orderBy, $orderDirect)
            ->paginate($request->get('limit', 10));

        return $this->response('Успешно получены', [
            'items' => ClientResource::collection($clients),
            'pagination' => [
                'total_pages' => $clients->lastPage(),
                'total_items' => $clients->total(),
                'current_page' => $clients->currentPage(),
                'limit' => $clients->perPage(),
            ],
        ]);
    }

    /**
     * @OA\GET (
     *      path="/v1/clients/{client}",
     *      operationId="getClientById",
     *      tags={"v1", "admin", "client"},
     *      summary="Получить клиента по ID",
     *      description="Получить клиента по ID",
     *      @OA\Response(
     *          response=200,
     *          description="Данные по клиенту",
     *          @OA\JsonContent(ref="#/components/schemas/ClientResource")
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Client $client
     * @return JsonResponse
     */
    public function getClientById(Client $client): JsonResponse
    {
        return $this->response('Данные по клиенту', new ClientResource($client));
    }

    /**
     * @OA\GET (
     *      path="/v1/clients/by/phone/{phone}",
     *      operationId="getClientByPhone",
     *      tags={"v1", "admin", "client"},
     *      summary="Получить клиента по номеру телефона",
     *      description="Получить клиента по номеру телефона",
     *      @OA\Response(
     *          response=200,
     *          description="Данные по клиенту",
     *          @OA\JsonContent(ref="#/components/schemas/ClientResource")
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param string $phone
     * @return JsonResponse
     */
    public function getClientByPhone(string $phone): JsonResponse
    {
        return $this->response('Данные по клиенту', new ClientResource(Client::where('phone', $phone)->firstOrFail()));
    }
}
