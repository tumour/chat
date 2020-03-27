<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Api resource для вывода пользователей
 *
 * Class UserResource
 * @package App\Http\Resources\V1
 */
class UserResource extends JsonResource
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
            'name' => $this->nickname,
            'avatar_color' => stringToColorHex($this->nickname),
            'created_at' => $this->created_at,
        ];
    }
}
