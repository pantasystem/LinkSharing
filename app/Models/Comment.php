<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Note;
use App\Models\Notification;
use App\Notificable;
use App\Models\NotificationFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'commentable_id'];

    public function author(): User
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


}
