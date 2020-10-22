<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notes;


class UsersController extends Controller
{
    
    function follow($userId)
    {

        $me = Auth::user();
       
        $user = User::find($userId);
        
        $me->follow($user);
    }

    function unfollow($userId)
    {
        $me = Auth::user();

        $user = User::find($userId);

        $me->follow($me);
    }

    function get($userId)
    {
        return User::find($userId);
    }

    function notes($userId)
    {
        return User::find($userId)->notes()->get();
    }
}
