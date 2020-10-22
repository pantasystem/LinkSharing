<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'text',
    ];

    function author(){
        $this->belongsTo(User::class, 'author_id');
    }

    function favoritedUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'note_id', 'user_id');
    }

    function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags_and_notes');
    }

    function favorite(User $user)
    {
        return $this->favoritedUsers()->attach($user);
    }

    function unfavorite(User $user)
    {
        return $this->favoritedUsers()->detach($user);
    }

    function favoriteCount()
    {
        return $this->favoritedUsers()->count();
    }

    function scopeWithFavoriteCount($query)
    {
        return $query->withCount(['favoritedUsers', 'favoritedUsers as favorite_count']);
    }
}
