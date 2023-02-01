<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getUserName')) {
    function getUserName($user_id)
    {

        $data = User::firstWhere('id', $user_id);

        return (null != $data->name) ? $data->name : 'No user name found';
    }
}