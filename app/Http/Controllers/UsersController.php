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
    
    function __construct()
    {
        $this->middleware('auth:sanctum');
    }
   

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
        return User::findOrFail($userId)->notes()->with(['author', 'tags', 'summary'])->simplePaginate(30);
    }

    function followerCountsRanking()
    {
        return User::withCountRelationModels()->orderBy('followers_count', 'desc')->simplePaginate(30);
    }

    function favoriteNotes($userId)
    {
        return User::findOrFail($userId)->favoritedNotes()->with('author')->simplePaginate(30);
    }

    function followers($userId)
    {
        $columns = [
            'users.*',
        ];
            
        if(Auth::check() && Auth::user()->id != $userId){
            $user = Auth::user();
            $columns['is_following'] = function($query) use ($user){
                $query->selectRaw('count(*)')
                    ->from('following_users')
                    ->where('following_users.user_id', '=', $user->id)
                    ->whereRaw('users.id = following_users.following_user_id');
            };
            $columns['is_follower'] = function($query) use ($user){
                $query->selectRaw('count(*)')
                    ->from('following_users')
                    ->where('following_users.following_user_id', '=', $user->id)
                    ->whereRaw('following_users.user_id = users.id');
            };
            
        }

        
        return User::where('id', '=', $userId)
            ->select($columns)->firstOrFail();


        return User::findOrFail($userId)->followers()->select($columns)->simplePaginate(30);
    }

    function followings($userId)
    {
        return User::findOrFail($userId)->followings()->simplePaginate(30);
    }

}
