<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Services\NotificationService;
use App\Events\Favorited;

class FavoritesController extends Controller
{
    
    function favorite(NotificationService $service, $noteId)
    {
        $user = Auth::user();

        $note = Note::findOrFail($noteId);

        return \DB::transaction(function () use($service, $note, $user){
            $created = Favorite::create([
                'note_id' => $note ->id,
                'user_id' => $user->id
            ]);
    
    
            Favorited::dispatch($created);
            //$service->create($user, $created);
            //return Favorite::findOrFail($created->id);
        });
        
        
        //$service->create($user, $created);

    }

    function unfavorite($noteId)
    {
        $user = Auth::user();

        $user->favoritedNotes()->detach($noteId);

        return [ 'user_id' => $user->id, 'note_id' => $noteId ];
    }

    function isFavorited($noteId)
    {

        $user = Auth::user();

        $note = $user->favoritedNotes()->findOrFail($noteId);
        return [ 'isFavorited' => $note != null ];

    }

    function favorites($noteId)
    {
        $note = Note::findOrFail($noteId);

        return $note->favoritedUsers()->paginate(30);
    }

    public function favoritedNotes()
    {
        $me = Auth::user();
        return $me->favorites()->withDetail($me)->simplePaginate();
    }
}
