<?php

namespace App\Repositories\Chat;

use App\User;
use Illuminate\Support\Collection;

/**
 * Репозиторий для работы с таблицей `chats`
 *
 * Class ChatRepository
 * @package App\Repositories\Chat
 */
class ChatRepository
{
    /**
     * Чаты пользователя
     *
     * @param User $user
     * @return Collection
     */
    public function get(User $user): Collection
    {
        return $user->chats()
            ->select('chats.id',
                'chats.created_at',
                'chats.is_dialog',
                \DB::raw('(
                        select `created_at`
                        from `chat_messages`
                        where `chat_id` = `chats`.`id`
                        order by `chat_messages`.`created_at` DESC
                        limit 1
                    ) as `last_message_at`'),
                \DB::raw('(
                        select `message`
                        from `chat_messages`
                        where `chat_id` = `chats`.`id`
                        order by `chat_messages`.`created_at` DESC
                        limit 1
                    ) as `last_message`'),
                \DB::raw("
                    case
                        when `chats`.`is_dialog` = 0
                            then `chats`.`name`
                        when `chats`.`is_dialog` = 1
                            then (
                                select `nickname`
                                from `users`
                                where `users`.`id` = (
                                    select `user_id`
                                    from `chat_user`
                                    where `user_id` <> {$user->id} and `chat_id` = `chats`.`id`
                                    limit 1
                                )
                            )
                    end as `name`"),
                )
            ->get();
    }
}
