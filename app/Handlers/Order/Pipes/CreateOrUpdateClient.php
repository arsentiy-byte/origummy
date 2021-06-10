<?php

declare(strict_types=1);

namespace App\Handlers\Order\Pipes;

use App\DTO\OrderDTO;
use App\Handlers\Order\OrderParam;
use App\Models\Client;
use Closure;

/**
 * Class CreateOrUpdateClient.
 */
final class CreateOrUpdateClient
{
    /**
     * @param OrderParam $orderParam
     * @param Closure $next
     * @return mixed
     */
    public function handle(OrderParam $orderParam, Closure $next): mixed
    {
        $client = $this->getClient($orderParam->getDto());
        $orderParam->setClient($client);

        return $next($orderParam);
    }

    /**
     * @param OrderDTO $orderDTO
     * @return Client
     */
    private function getClient(OrderDTO $orderDTO): Client
    {
        $client = Client::firstOrNew([
            'phone' => $orderDTO->phone,
        ]);

        $client->name = $orderDTO->name;
        $client->address = $orderDTO->address;
        $client->device_info = $orderDTO->deviceInfo;

        $client->save();

        return $client;
    }
}
