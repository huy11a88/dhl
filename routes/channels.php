<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

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

// Broadcast::channel('chat.{user_id}', function (User $user, $user_id) {
//     return true;
//     // return (int) $user->id === (int) $user_id || $user->role === UserRole::CUSTOMER_SERVICE_STAFF;
// });

Broadcast::channel('chat.{roomId}', function (User $user, int $roomId) {
    if ($user->canJoinRoom($roomId)) {
        return ['id' => $user->id, 'name' => $user->name];
    }

    return false;
});