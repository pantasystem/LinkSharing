<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Notification;
use App\Notificable;


class FollowingUser extends Model
{

    protected $table = 'following_users';

    protected $fillable = ['following_user_id', 'user_id'];

    /**
     * フォローしている相手
     */
    public function followingUser(){
        return $this->belongsTo(User::class, 'following_user_id');
    }

    /**
     * 自分
     */

     public function user(){
         return $this->belongsTo(User::class, 'user_id');
     }


   
}
