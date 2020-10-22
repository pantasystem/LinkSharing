<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Note;


class Favorite extends Pivot
{

    function user()
    {
        return belongsTo(User::class);
    }

    function note()
    {

        return belongsTo(Note::class);
        
    }

}
