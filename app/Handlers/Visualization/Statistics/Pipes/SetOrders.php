<?php

declare(strict_types=1);

namespace App\Handlers\Visualization\Statistics\Pipes;

use App\Handlers\Visualization\Statistics\StatisticsParam;
use App\Http\Resources\OrderResource;
use App\Models\Order\Order;
use Closure;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class SetOrders.
 */
final class SetOrders
{
    public function handle(StatisticsParam $param, Closure $next)
    {
        $param->setOrders($this->getOrders());

        return $next($param);
    }

    /**
     * @return AnonymousResourceCollection
     */
    private function getOrders(): AnonymousResourceCollection
    {
        $orders = Order::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->get();

        return OrderResource::collection($orders);
    }
}
