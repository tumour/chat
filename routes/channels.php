<?php

use Illuminate\Support\Facades\Broadcast;
use App\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{chatId}', function (User $user, $chatId) {
    $accessToChat = $user->chats()->where('chats.id', $chatId)->first();
    if ($accessToChat === null) {
        return false;
    }
    return true;
});
