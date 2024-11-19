<?php

use Illuminate\Support\Facades\Broadcast;

/*
|---------------------------------------------------------------------------
| Broadcast Channels
|---------------------------------------------------------------------------
*/

// Users
Broadcast::channel('users.{id}', function ($user, $id) {
    return  (int) $user->id === (int) $id;
});
