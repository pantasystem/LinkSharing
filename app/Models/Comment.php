<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Note;
use App\Models\Notification;
use App\Notificable;

class Comment extends Model implements Notificable
{
    use HasFactory;

    public function author(): User
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    
    public function replyToComment(): ?Comment
    {
        return $this->belongsTo(Comment::class, 'reply_tocomment_id');
    }

    public function replyToNote(): Note
    {
        return $this->belongsTo(Comment::class, 'reply_to_note_id');
    }

    public function notificable()
    {
        return $this->hasOne(Notification::class, 'reply_to_comment_id');
    }
}
