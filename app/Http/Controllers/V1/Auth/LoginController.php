<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Контроллер авторизации
 *
 * Class LoginController
 * @package App\Http\Controllers\V1\Auth
 */
class LoginController extends Controller
{
    /**
     * Авторизировать пользователя
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) : JsonResponse
    {
        $validate = $request->validate([
            'nickname' => 'required|exists:users,nickname',
            'password' => 'required',
        ]);

        $user = User::where('nickname', $validate['nickname'])
            ->first();

        if (Hash::check($validate['password'], $user->password)) {
            return response()->json([
                'token' => $user->api_token,
                'nickname' => $user->nickname,
            ]);
        }

        throw ValidationException::withMessages([
            $validate['nickname'] => [trans('auth.failed')],
        ]);
    }
}
