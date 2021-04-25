<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogoutController extends Controller
{
    /**
     * @OA\Get (
     *      path="/auth/logout",
     *      operationId="logout",
     *      tags={"auth"},
     *      summary="",
     *      description="Выход пользователя (Разлогиниться)",
     *     @OA\Header(
     *         header="Authorization",
     *         description="Token for user authorization",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Logged out"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->user()->token()->delete();

        return $this->response('Logged out');
    }
}
