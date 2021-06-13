<?php

declare(strict_types=1);

namespace App\Handlers\Visualization\Statistics;

use App\Handlers\InterfaceParam;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\Pure;

/**
 * Class StatisticsParam.
 */
final class StatisticsParam implements InterfaceParam
{
    /**
     * @var array
     */
    private array $total;

    /**
     * @var array
     */
    private array $charts;

    /**
     * @var AnonymousResourceCollection
     */
    private AnonymousResourceCollection $orders;

    /**
     * @return array[]
     */
    #[Pure]
 public function getResult(): array
 {
     return [
            'total' => $this->getTotal(),
            'charts' => $this->getCharts(),
            'orders' => $this->getOrders(),
        ];
 }

    /**
     * @return array
     */
    public function getCharts(): array
    {
        return $this->charts;
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getOrders(): AnonymousResourceCollection
    {
        return $this->orders;
    }

    /**
     * @return array
     */
    public function getTotal(): array
    {
        return $this->total;
    }

    /**
     * @param array $charts
     */
    public function setCharts(array $charts): void
    {
        $this->charts = $charts;
    }

    /**
     * @param AnonymousResourceCollection $orders
     */
    public function setOrders(AnonymousResourceCollection $orders): void
    {
        $this->orders = $orders;
    }

    /**
     * @param array $total
     */
    public function setTotal(array $total): void
    {
        $this->total = $total;
    }
}
