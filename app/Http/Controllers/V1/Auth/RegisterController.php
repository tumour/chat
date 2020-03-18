<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Контроллер регистрации
 *
 * Class RegisterController
 * @package App\Http\Controllers\V1\Auth
 */
class RegisterController extends Controller
{
    /**
     * Регистрация
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) : JsonResponse
    {
        $validate = $request->validate([
            'nickname' => 'required|unique:users,nickname|max:150',
            'password' => 'required'
        ]);

        $user = User::create([
            'nickname' => $validate['nickname'],
            'password' => Hash::make($validate['password']),
            'api_token' => Str::random(36),
        ]);

        return response()->json([
            'token' => $user->api_token,
            'nickname' => $user->nickname,
        ]);
    }
}
