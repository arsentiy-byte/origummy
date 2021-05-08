<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AuthController extends Controller
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
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="phone",
     *                      description="Номер телефона пользователя",
     *                      type="string"
     *                   ),
     *                  @OA\Property(
     *                      property="password",
     *                      description="Пароль пользователя",
     *                      type="string"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Authenticated"
     *      ),
     *      @OA\Response(response=401, description="Неверный логин/пароль или пользователь не существует"),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ], $request->all());

        $user = User::where('phone', $validated['phone'])->first();

        if (empty($user) || ! Hash::check($validated['password'], $user->password)) {
            return $this->response('Неверный логин/пароль или пользователь не существует', [], 401, 'error');
        }

        Auth::login($user);
        $user = Auth::user();

        $token = $user->createToken(config('auth.token'));

        return $this->response('Authenticated', [
            'access_token' => $token->accessToken,
            'expires_in' => $token->token->expires_at->diffInSeconds(Carbon::now()),
            'user' => $user,
        ]);
    }

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
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->delete();

        return $this->response('Logged out');
    }

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
     *          description="Пользователь"
     *      ),
     *      @OA\Response(response=400, description="Что-то не так")
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        return $this->response('Пользователь', [
            'user' => $request->user(),
        ]);
    }
}
