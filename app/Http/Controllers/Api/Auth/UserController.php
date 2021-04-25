<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class UserController extends Controller
{
    /**
     * @OA\Get (
     *      path="/auth/user",
     *      operationId="user",
     *      tags={"auth"},
     *      summary="",
     *      description="Get user by token",
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
     *          description="User"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return $this->response('User', [
            'user' => Auth::user(),
        ]);
    }
}
