<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\View;
use App\Models\Tag;
use App\Models\User;

class UsingTagCount extends View
{
    use HasFactory;


    

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
