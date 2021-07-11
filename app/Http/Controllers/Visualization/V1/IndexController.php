<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visualization\V1;

use App\Handlers\Visualization\Statistics\StatisticsHandler;
use App\Handlers\Visualization\Statistics\StatisticsParam;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Class IndexController.
 */
final class IndexController extends Controller
{
    /**
     * @OA\GET (
     *      path="/web/v1/statistics",
     *      operationId="getStatistics",
     *      tags={"v1", "admin", "web"},
     *      summary="Статистика в главное странице админки",
     *      description="Статистика в главное странице админки",
     *      @OA\Response(response=200, description="Успешно получены"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param StatisticsHandler $handler
     * @return JsonResponse
     * @throws Throwable
     */
    public function getStatistics(StatisticsHandler $handler): JsonResponse
    {
        return $this->response('Успешно получены', $handler->handle(new StatisticsParam()));
    }
}
