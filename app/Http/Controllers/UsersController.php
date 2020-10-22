<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth;


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
        return User::withCountRelationModels()->find($userId);
    }

    function notes($userId)
    {
        return User::find($userId)->notes()->paginate(30);
    }

    function followerCountsRanking()
    {
        return User::withCountRelationModels()->orderBy('followers_count', 'desc')->paginate(30);
    }

    function favoriteNotes($userId)
    {
        return User::find($userId)->favoritedNotes()->with('author')->paginate(30);
    }
}
