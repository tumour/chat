<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Api resource для вывода чатов
 *
 * Class ChatResource
 * @package App\Http\Resources\V1
 */
class ChatResource extends JsonResource
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
            'name' => $this->name,
            'avatar_color' => stringToColorHex($this->name),
            'last_message' => $this->last_message,
            'created_at' => $this->created_at,
            'last_message_at' => $this->last_message_at,
        ];
    }
}
