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
        \DB::transaction(function () use($me, $user, $notificationService){
            $followingUser = FollowingUser::create([
                'following_user_id' => $user->id,
                'user_id' => $me->id
            ]);

            $notificationService->create($me, $followingUser);
        });
        
        return response()->json(null, 204);

        
    }

    function unfollow($userId)
    {
        $me = Auth::user();

        $user = User::findOrFail($userId);

        //$me->unfollow($user);
        \DB::transaction(function () use($user, $me){
            FollowingUser::where('following_user_id', '=', $user->id)
            ->where('user_id', '=', $me->id)->delete();
        });        
        

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

    function followers(Request $request, $userId)
    {
        $columns = [
            'users.*',
        ];
        
        $user = User::findOrFail($userId);
        $query = $user->followers()->select($columns);

        if(auth('sanctum')->check()){
            $user = auth('sanctum')->user();
            $columns = [];
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
            $query->select($columns);
            
        }

        return $query->simplePaginate();

        
    }

    function followings($userId)
    {
        return User::findOrFail($userId)->followings()->simplePaginate(30);
    }

}
