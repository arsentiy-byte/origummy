<?php

declare(strict_types=1);

namespace App\Handlers\Order\Pipes;

use App\Handlers\Order\OrderParam;
use App\Models\Order\Order;
use Closure;

/**
 * Class CreateOrder.
 */
final class CreateOrder
{
    /**
     * @param OrderParam $orderParam
     * @param Closure $next
     * @return mixed
     */
    public function handle(OrderParam $orderParam, Closure $next): mixed
    {
        $data = $orderParam->getDto()->getOrderData();
        $data['client_id'] = $orderParam->getClient()->id;
        $order = Order::create($data);

        $orderParam->setOrder($order);

        return $next($orderParam);
    }
}
