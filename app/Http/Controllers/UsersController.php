<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use App\Models\FollowingUser;
use App\Events\Followed;

class UsersController extends Controller
{
   
    
   

    function follow($userId)
    {

        $me = Auth::user();
       
        $user = User::findOrFail($userId);
        \DB::transaction(function () use($me, $user){
            $followingUser = FollowingUser::create([
                'following_user_id' => $user->id,
                'user_id' => $me->id
            ]);

            Followed::dispatch($followingUser);
        });
        
        return $this->get($userId);


        
    }

    function unfollow($userId)
    {
        $me = Auth::user();

        $user = User::findOrFail($userId);

        $me->unfollow($user);
        \DB::transaction(function () use($user, $me){
            FollowingUser::where('following_user_id', '=', $user->id)
            ->where('user_id', '=', $me->id)->delete();
        });        
        

        return $this->get($userId);
    }

    public function get($userId)
    {

        $query = User::select('users.*')->where('id', '=', $userId);
        $me = auth('sanctum')->user();

        return $query->withDetail($me)->firstOrFail();
    }

    function followers(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $query = $user->followers();

        $me = auth('sanctum')->user();

        return $query->withDetail($me)
            ->orderBy('following_users.id', 'desc')->simplePaginate();
        
    }

    function followings($userId)
    {

        

        $query =  User::findOrFail($userId)
            ->followings();
        
        $me = auth('sanctum')->user();

        return $query->withDetail($me)
            ->orderBy('following_users.id', 'desc')
            ->simplePaginate(30);
    }


    function notes($userId)
    {
        return User::findOrFail($userId)->notes()->withDetail(auth('sanctum')->user())->orderBy('id', 'desc')->simplePaginate(30);
    }

    function followerCountsRanking()
    {
        return User::withCountModels()->orderBy('followers_count', 'desc')->simplePaginate(30);
    }

    function favoriteNotes($userId)
    {
        return User::findOrFail($userId)->favoritedNotes()->with('author')->simplePaginate(30);
    }


}
