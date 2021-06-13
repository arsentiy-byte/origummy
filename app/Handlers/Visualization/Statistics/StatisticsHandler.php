<?php

declare(strict_types=1);

namespace App\Handlers\Visualization\Statistics;

use App\Handlers\Visualization\Statistics\Pipes\SetCharts;
use App\Handlers\Visualization\Statistics\Pipes\SetOrders;
use App\Handlers\Visualization\Statistics\Pipes\SetTotal;
use App\Handlers\WithResultsHandler;

/**
 * Class StatisticsHandler.
 */
final class StatisticsHandler extends WithResultsHandler
{
    public const PIPES = [
        SetCharts::class,
        SetOrders::class,
        SetTotal::class,
    ];
}
