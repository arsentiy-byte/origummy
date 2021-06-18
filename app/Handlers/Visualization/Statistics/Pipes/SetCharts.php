<?php

declare(strict_types=1);

namespace App\Handlers\Visualization\Statistics\Pipes;

use App\Handlers\Visualization\Statistics\StatisticsParam;
use App\Models\Client;
use App\Models\Order\Order;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class SetCharts.
 */
final class SetCharts
{
    /**
     * @param StatisticsParam $param
     * @param Closure $next
     * @return mixed
     */
    public function handle(StatisticsParam $param, Closure $next): mixed
    {
        $param->setCharts($this->getCharts());

        return $next($param);
    }

    /**
     * @return array[]
     */
    private function getCharts(): array
    {
        $clients = $this->getChartBuilder(Client::query())->get()->toArray();
        $orders = $this->getChartBuilder(Order::query())->get()->toArray();

        return [
            'clients' => $this->getChartResult($clients),
            'orders' => $this->getChartResult($orders),
        ];
    }

    /**
     * @param array $items
     * @return array
     */
    private function getChartResult(array $items): array
    {
        $result = [];

        $days = array_column($items, 'day');

        for ($i = 0; $i < now()->daysInMonth; $i++) {
            $index = array_search($i + 1, $days);
            if ($index !== false) {
                $result[] = (int) $items[$index]['data'];
                continue;
            }

            $result[] = 0;
        }

        return $result;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    private function getChartBuilder(Builder $builder): Builder
    {
        return $builder
            ->select(
                DB::raw('count(id) as data'),
                DB::raw("TO_CHAR(created_at, 'DD') as day")
            )
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->groupBy('day')->orderBy('day');
    }
}
