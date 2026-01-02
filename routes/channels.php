<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin-channel', function ($user) {
    // Check if the user is an admin (e.g., has 'admin' or 'super_admin' role)
    // Adjust this logic based on your actual User model/Role implementation
    return in_array($user->role, ['admin', 'super_admin']);
});

Broadcast::channel('teller.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
