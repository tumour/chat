<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\AuthenticationRequest;
use App\Http\Resources\V1\UserResource;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

/**
 * Авторизация пользователя
 *
 * Class AuthenticationController
 * @package App\Http\Controllers\V1\Auth
 */
class AuthenticationController extends Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * AuthenticationController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Аунтефикация
     *
     * @param AuthenticationRequest $request
     * @return UserResource
     * @throws ValidationException
     * @throws \Throwable
     */
    public function authentication(AuthenticationRequest $request): JsonResource
    {
        $dataRequest = $request->only('nickname', 'password');

        $user = User::where('nickname', $dataRequest['nickname'])->first();
        if ($user === null) {
            return $this->register($request->only('nickname', 'password'));
        }

        return $this->login($user, $dataRequest['password']);
    }

    public function authCheck(Request $request)
    {
        $validatedData = $request->validate(['api_token' => 'required']);

        $user = User::select('id')
            ->where('api_token', $validatedData['api_token'])
            ->first();

        if ($user === null) {
            throw new UnauthorizedException('unauthorized');
        }

        return response()->json(['api_token' => $validatedData['api_token']]);
    }

    /**
     * Логин
     *
     * @param User $user
     * @param string $password
     * @return UserResource
     * @throws ValidationException
     */
    protected function login(User $user, $password) : UserResource
    {
        if (Hash::check($password, $user->password)) {

            $token = Str::random(60);

            $user->api_token = hash('sha256', $token);
            $user->save();

            return (new UserResource($user))->additional(['api_token' => $token]);
        }

        throw ValidationException::withMessages([
            $user->nickname => [trans('auth.invalid_password')],
        ]);
    }

    /**
     * Регистрация
     *
     * @param array $data
     * @return UserResource
     * @throws \Throwable
     */
    protected function register(array $data): UserResource
    {
        $data['api_token'] = Str::random(60);

        $user = $this->userRepository->create($data);

        return (new UserResource($user))->additional(['api_token' => $data['api_token']]);
    }
}
