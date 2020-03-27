<?php

namespace App\Repositories;

use App\Models\Chat;
use App\User;

/**
 * Репозиторий для работы с таблицей `users`
 *
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * Создание пользователя
     * Добавляем нового пользователя в дефолтный чат
     *
     * @param array $data
     * @return User
     * @throws \Throwable
     */
    public function create(array $data): User
    {
        $chat = Chat::select('id')->where('index', Chat::DEFAULT_CHAT_INDEX)->first();

        \DB::beginTransaction();
        try {
            $user = User::create([
                'nickname' => $data['nickname'],
                'password' => \Hash::make($data['password']),
                'api_token' => hash('sha256', $data['api_token']),
            ]);

            $chat->users()->attach($user->id);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $user;
    }
}
