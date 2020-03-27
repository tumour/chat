<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Api resource для вывода сообщений чата
 *
 * Class ChatMessageResource
 * @package App\Http\Resources\V1
 */
class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at,
        ];
    }
}
