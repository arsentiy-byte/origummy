<?php

declare(strict_types=1);

namespace App\Handlers\Order;

use App\Handlers\Order\Pipes\AssignProductsToOrder;
use App\Handlers\Order\Pipes\CreateOrder;
use App\Handlers\Order\Pipes\CreateOrUpdateClient;
use App\Handlers\WithResultsHandler;

/**
 * Class OrderHandler.
 */
final class OrderHandler extends WithResultsHandler
{
    public const PIPES = [
        CreateOrUpdateClient::class,
        CreateOrder::class,
        AssignProductsToOrder::class,
    ];
}
