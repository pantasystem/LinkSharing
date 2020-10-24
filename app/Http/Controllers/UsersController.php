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
       
        $user = User::findOrFail($userId);
        
        if($me->follow($user)){
            return response()->json(null, 204);
        }else{
            abort(422);
        }
    }

    function unfollow($userId)
    {
        $me = Auth::user();

        $user = User::findOrFail($userId);

        $me->unfollow($user);

        return response()->json(null, 204);
    }

    function get($userId)
    {
        return User::withCountRelationModels()->findOrFail($userId);
    }

    function notes($userId)
    {
        return User::findOrFail($userId)->notes()->paginate(30);
    }

    function followerCountsRanking()
    {
        return User::withCountRelationModels()->orderBy('followers_count', 'desc')->paginate(30);
    }

    function favoriteNotes($userId)
    {
        return User::findOrFail($userId)->favoritedNotes()->with('author')->paginate(30);
    }

    function followers($userId)
    {
        return User::findOrFail($userId)->followers()->paginate(30);
    }

    function followings($userId)
    {
        return User::findOrFail($userId)->followings()->paginate(30);
    }

}
