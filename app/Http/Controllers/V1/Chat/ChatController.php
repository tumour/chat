<?php

namespace App\Http\Controllers\V1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ChatResource;
use App\Repositories\Chat\ChatRepository;
use App\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Контроллер для работы с чатами
 *
 * Class ChatController
 * @package App\Http\Controllers\V1\Chat
 */
class ChatController extends Controller
{
    /**
     * @var ChatRepository
     */
    private ChatRepository $chatRepository;

    /**
     * ChatController constructor.
     * @param ChatRepository $chatRepository
     */
    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    /**
     * Чаты пользователей
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = auth()->user();

        $chats = $this->chatRepository->get($user);

        return ChatResource::collection($chats);
    }
}
