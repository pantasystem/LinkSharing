<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use App\Models\Note;
use App\Models\Favorite;
use App\Models\Follow;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id', 'publisher_id', 'comment_id', 'favorite_id', 'follow_id', 'is_read'
    ];

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    

    public function subscribe(User $user)
    {
        $this->subscriber()->associate($user);
        return $this;
    }

    public function publish(User $user)
    {
        $this->subscriber()->associate($user);
        return $this;
    }

    public function comment(){
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    

    public function favorite(){
        return $this->belongsTo(Favorite::class, 'favorite_id');
    }

    public function follow(){
        return $this->belongsTo(Follow::class, 'follow_id');
    }
    
}
