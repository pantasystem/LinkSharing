<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Note;
use App\Notificable;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;


class Favorite extends Model
{
    protected $table = 'favorites';
    
    protected $hidden = [
        'pivot'
    ];

    protected $fillable = [
        'user_id', 'note_id'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function note()
    {

        return $this->belongsTo(Note::class);
        
    }


}
