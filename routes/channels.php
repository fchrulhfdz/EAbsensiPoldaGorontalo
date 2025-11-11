<?php

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

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Jika tidak menggunakan broadcasting, kita bisa kosongkan file ini
// atau berikan channel default yang sederhana

Broadcast::channel('attendance.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Channel untuk admin notifications
Broadcast::channel('admin.notifications', function ($user) {
    return $user->isAdmin() || $user->isSuperAdmin();
});