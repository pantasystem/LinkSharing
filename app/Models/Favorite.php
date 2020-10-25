<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Note;
use App\Notificable;
use App\Models\Notification;

class Favorite extends Pivot
{
    protected $hidden = [
        'pivot'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function note()
    {

        return $this->belongsTo(Note::class);
        
    }

    public function notificable()
    {
        return $this->hasOne(Notificatin::class, 'favorite_id');
    }

}
