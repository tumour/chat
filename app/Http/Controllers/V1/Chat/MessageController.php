<?php

namespace App\Http\Controllers\V1\Chat;

use App\Events\Chat\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Chat\MessageRequest;
use App\Http\Resources\V1\ChatMessageResource;
use App\Models\Chat;
use App\Models\ChatMessage;

/**
 * Контроллер для работы с сообщениями чата
 *
 * Class MessageController
 * @package App\Http\Controllers\V1\Chat
 */
class MessageController extends Controller
{
    /**
     * Сообщения чата
     *
     * @param Chat $chat
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Chat $chat)
    {
        $chat->users()->where('users.id', auth()->user()->id)->firstOrFail();

        $chatMessages = ChatMessage::with('user:id,nickname,created_at')
            ->where('chat_id', $chat->id)
            ->get();

        return ChatMessageResource::collection($chatMessages);
    }

    /**
     * @param Chat $chat
     * @param MessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Chat $chat, MessageRequest $request)
    {
        $chatMessage = ChatMessage::create([
            'chat_id' => $chat->id,
            'user_id' => auth()->user()->id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($chatMessage))->toOthers();

        return response()->json(['success' => true]);
    }
}