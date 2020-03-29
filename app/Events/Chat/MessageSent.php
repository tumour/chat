<?php

namespace App\Events\Chat;

use App\Http\Resources\V1\ChatMessageResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Message details
     *
     * @var ChatMessageResource
     */
    public ChatMessageResource $message;

    /**
     * Create a new event instance.
     *
     * MessageSent constructor.
     * @param ChatMessageResource $chatMessageResource
     */
    public function __construct(ChatMessageResource $chatMessageResource)
    {
        $this->message = $chatMessageResource;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->message    ->chat_id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'message.sent';
    }
}
