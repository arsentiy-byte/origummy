<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\Queries\Procedures\AuthProcedure;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Class LoginController.
 */
final class LoginController extends Controller
{
    /**
     * @OA\Post (
     *      path="/auth/login",
     *      operationId="login",
     *      tags={"auth"},
     *      summary="Аутентификация пользователя",
     *      description="Аутентификация пользователя",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/LoginRequest")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Authenticated"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     *
     * @psalm-suppress PossiblyNullReference
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $server = [
            'REMOTE_ADDR' => $request->server('REMOTE_ADDR'),
            'HTTP_USER_AGENT' => $request->server('HTTP_USER_AGENT'),
        ];

        $user = AuthProcedure::auth($validated, $server);

        Auth::login($user);

        $user = Auth::user();

        $token = $user->createToken(config('auth.token'));

        return $this->response('Authenticated', [
            'access_token' => $token->accessToken,
            'expires_in' => $token->token->expires_at->diffInSeconds(Carbon::now()),
            'user' => $user,
        ]);
    }
}
