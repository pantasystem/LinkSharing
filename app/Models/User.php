<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Note;
use App\Models\FollowingUser;
use App\Models\Comment;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
        'pivot'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_following' => 'boolean',
        'is_follower' => 'boolean'
    ];

    function followings(){

        // 引数を間違えているかも知れない
        return $this->belongsToMany(User::class, 'following_users', 'user_id', 'following_user_id');
    }

    function followers(){
        return $this->belongsToMany(User::class, 'following_users', 'following_user_id', 'user_id');
    }

    function timeline(){

        return $this->hasManyThrough(
            Note::class,//ok
            FollowingUser::class,//ok
            'user_id', // FollowingUserの外部キー(Userを参照している) ok
            'author_id', // Noteの外部キー(FollowingUserのfollowing_user_idを主キー, Noteのidを外部キーということにしている)
            null,
            'following_user_id' // FollowingUser のローカルキー
            
        );
        

    }

    /**
     * 自分の作成したノートを取得します。
     */
    function notes(){
        return $this->hasMany(Note::class, 'author_id');
    }

    function favoritedNotes()
    {
        return $this->belongsToMany(Note::class, 'favorites', 'user_id', 'note_id');
    }

    function follow(User $user)
    {
        if($user->id == $this->id){
            return false;
        }
        $this->followings()->attach($user);

        return true;
    }

    function unfollow(User $user){
        return $this->followings()->detach($user);
    }

    function scopeWithCountRelationModels($query){
        return $this->withCount(['followers', 'followings', 'notes', 'favoritedNotes']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'subscriber_id');
    }
}
