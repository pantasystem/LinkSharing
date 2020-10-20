<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Note;
use App\Modelss\FollowingUser;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
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
        'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function followings(){

        // 引数を間違えているかも知れない
        return $this->belongsToMany(User::class, 'following_user', 'user_id', 'following_user_id');
    }

    function followers(){
        return $this->belongsToMany(User::class, 'following_user', 'following_user_id', 'user_id');
    }

    function timeline(){

        return $this->hasManyThrough(
            Note::class,
            FollowingUser::class,
            'user_id', // FollowingUserの外部キー(Userを参照している)
            'id', // Noteの外部キー(FollowingUserのfollowing_user_idを主キー, Noteのidを外部キーということにしている)
            'id', // Userのローカルキー
            'following_user_id' // FollowingUser のローカルキー
            
        );
        

    }

    /**
     * 自分の作成したノートを取得します。
     */
    function notes(){
        return $this->hasMany(Note::class, 'author_id');
    }
    

}
