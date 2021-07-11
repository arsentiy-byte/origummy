<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visualization;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], $request->all());

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin');
        }

        return redirect()->to(route('web-login'))->with('error', 'Неверный логин/пароль или пользователь не существует!');
    }

    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->to(route('web-login'));
    }

    /**
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        return $this->response('Пользователь', [
            'user' => Auth::user(),
        ]);
    }
}
