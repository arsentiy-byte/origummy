<?php

declare(strict_types=1);

namespace App\Handlers\Visualization\Statistics\Pipes;

use App\Handlers\Visualization\Statistics\StatisticsParam;
use App\Models\Client;
use App\Models\Order\Order;
use Closure;

/**
 * Class SetTotal.
 */
final class SetTotal
{
    /**
     * @param StatisticsParam $param
     * @param Closure $next
     * @return mixed
     */
    public function handle(StatisticsParam $param, Closure $next): mixed
    {
        $param->setTotal($this->getTotal());

        return $next($param);
    }

    /**
     * @return array
     */
    private function getTotal(): array
    {
        $clients = Client::all()->count();
        $sales = Order::with('products', 'orderProducts')->get()->sum(function ($order) {
            $total = 0;

            foreach ($order->orderProducts as $orderProduct) {
                $total += $orderProduct->count * $order->products->find($orderProduct->product_id)->price;
            }

            return (float) $total;
        });
        $orders = Order::all()->count();

        return [
            'clients' => $clients,
            'sales' => $sales,
            'orders' => $orders,
        ];
    }
}
