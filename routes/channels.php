<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('classroom.{classroomId}', function (User $user, $classroomId) {
    // ⚡ ১. নিশ্চিত করুন এখানে যেন শুধু true রিটার্ন না করে, প্রেজেন্স চ্যানেলের জন্য ইউজারের অ্যারে রিটার্ন করে!
    // এই অ্যারের ডাটায় যা থাকবে, সেটাই .here() এবং .joining()-এ অন্য ব্রাউজাররা দেখতে পাবে।
    if ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }

    return false;
});
