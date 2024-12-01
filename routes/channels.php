<?php

use Illuminate\Support\Facades\Broadcast;

/*
|---------------------------------------------------------------------------
| Broadcast Channels
|---------------------------------------------------------------------------
*/

// User Channel Authorization
Broadcast::channel('users.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Admin Channel Authorization
Broadcast::channel('admins.{id}', function ($admin, $id) {
    return (int) $admin->id === (int) $id;
}, ['guards' => ['admin']]);
