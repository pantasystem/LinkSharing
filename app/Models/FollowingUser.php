<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Notification;
use App\Notificable;


class FollowingUser extends Pivot implements Notificable
{

    protected $table = 'following_users';

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


     public function notificable()
     {
         return $this->hasOne(Notification::class, 'follow_id');
     }

}
