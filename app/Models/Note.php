<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;
use App\Models\Summary;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\Relation;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'text',
        'summary_id'
    ];

    protected $hidden = [
        'pivot'
    ];

    protected $casts = [
        'is_favorited' => 'boolean'
    ];

    function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    function summary()
    {
        return $this->belongsTo(Summary::class, 'summary_id');
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

    public function scopeIsFavorite($query, User $user)
    {
        $relation = Relation::noConstraints(function () {
            return $this->favoritedUsers();
        });
        $q = $this->favoritedUsers()->getRelationExistenceCountQuery(
            $relation->getRelated()->where('user_id', $user->id)->newQuery(), $query
        );

        $query->selectSub($q->toBase(), 'is_favorited');
    }

  
    public function scopeWithDetail($query, User $user){
        $columns = ['notes.*'];
        if(isset($user)){
            $columns['is_favorited'] = function($query) use ($user){
                $query->selectRaw('count(*)')
                    ->from('favorites')
                    ->whereRaw('favorites.note_id = notes.id')
                    ->where('favorites.user_id', '=', $user->id);
            };
        }
        

        $columns['favorite_count'] = function($query){
            $query->selectRaw('count(*)')
                ->from('favorites')
                ->whereRaw('favorites.note_id = notes.id');
        };

        return $query->addSelect($columns)
            ->with(['summary', 'tags', 'author']);
    }

    function scopeWithFavoriteCount($query)
    {
        return $query->withCount(['favoritedUsers', 'favoritedUsers as favorite_count']);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
