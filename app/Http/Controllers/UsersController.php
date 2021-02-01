<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use App\Models\FollowingUser;
use App\Events\Followed;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Tag;
use App\Models\UsingTagCount;
use DB;

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

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'user_name' =>  ['required', 'alpha_dash','alpha_num', 'max:15', Rule::unique('users')->ignore($user->id)],
            'avatar_image' => ['file', 'image', 'max:10000']
        ]);

        $user->fill($request->only(['user_name']));
        if($request->file('avatar_image')){
            // 既存のアバター画像があれば削除をする
            if(isset($user->avatar_icon) && Storage::disk('public')->exists($user->avatar_icon)){
                Storage::disk('public')->delete($user->avatar_icon);
            }

            $path = $request->file('avatar_image')->store('avatars', 'public');
            $user->avatar_icon = $path;
            \Log::debug('path:' . $user->avatar_icon);
        }
        $user->save();

        return $user->loadCount(User::$counts);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(
            ['avatar_image' => ['required','file', 'image', 'max:10000']]
        );
        $user = Auth::user();
        $path = $request->file('avatar_image')->store('avatars', 'public');
        
        // 既存のアバター画像があれば削除をする
        if(isset($user->avatar_icon) && Storage::disk('public')->exists($user->avatar_icon)){
            Storage::disk('public')->delete($user->avatar_icon);
        }
        $user->fill(['avatar_icon' => $path]);

        $user->save();

        return $user->loadCount(User::$counts);
        
    }

    /**
     * 入力されたタグをもとにタグに関連するユーザーをタグの使用頻度の高い順にソートして返します。
     */
    public function relatedToTags(Request $request)
    {

        $query = DB::table('users')
            ->leftJoin('notes', 'users.id', '=', 'notes.author_id')
            ->join('tags_and_notes', 'tags_and_notes.note_id', '=', 'notes.id')
            ->join('tags', 'tags.id', 'tags_and_notes.tag_id')
            ->groupBy('users.id')
            ->selectRaw('users.*, count(users.id) as relatid_count')
            ->orderBy('relatid_count', 'desc');
        if(Auth::check()){
            $query->where('users.id', '<>', Auth::id());
        }
        $tags = $request->input('tags');

        if(isset($tags) && !is_array($tags)){
            $tags = [$tags];
        }
        if(is_array($tags) && !empty($tags)){
            $query->whereIn('tags.name', $tags);
        }
        User::isFollowingQuery($query, Auth::user());
        User::isFollowerQuery($query, Auth::user());

        $result = $query->get();
        return User::hydrate($result->toArray())->loadCount(User::$counts);

    }

}
