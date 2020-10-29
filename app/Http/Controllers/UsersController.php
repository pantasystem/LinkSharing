<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use App\Models\FollowingUser;


class UsersController extends Controller
{
    
   

    function follow(NotificationService $notificationService, $userId)
    {

        $me = Auth::user();
       
        $user = User::findOrFail($userId);
        
        $followingUser = FollowingUser::create([
            'following_user_id' => $user->id,
            'user_id' => $user->id
        ]);

        return response()->json(null, 204);

        
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
        return User::findOrFail($userId)->notes()->simplePaginate(30);
    }

    function followerCountsRanking()
    {
        return User::withCountRelationModels()->orderBy('followers_count', 'desc')->paginate(30);
    }

    function favoriteNotes($userId)
    {
        return User::findOrFail($userId)->favoritedNotes()->with('author')->simplePaginate(30);
    }

    function followers($userId)
    {
        return User::findOrFail($userId)->followers()->simplePaginate(30);
    }

    function followings($userId)
    {
        return User::findOrFail($userId)->followings()->simplePaginate(30);
    }

}
