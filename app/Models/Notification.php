<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;

class Notification extends Model
{
    use HasFactory;

    public function subscriber()
    {
        return $this->belongsTo(User::class, 'subscriber_id');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    public function replyToComment()
    {
        return $this->belongsTo(Comment::class, 'reply_to_comment_id');
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
    
}
