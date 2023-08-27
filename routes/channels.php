<?php

use App\Enums\UserRole;
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

Broadcast::channel('chat.{user_id}', function ($user, $user_id) {
    return true;
    // return (int) $user->id === (int) $user_id || $user->role === UserRole::CUSTOMER_SERVICE_STAFF;
});
