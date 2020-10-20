<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;


class FollowingUser extends Pivot
{

    protected $table = 'following_users';

    /**
     * フォローしている相手
     */
    function followingUser(){
        return $this->belongsTo(User::class, 'following_user_id');
    }

    /**
     * 自分
     */

     function user(){
         return $this->belongsTo(User::class, 'user_id');
     }
}
