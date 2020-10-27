<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Services\NotificationService;

class FavoritesController extends Controller
{
    
    function favorite(NotificationService $service, $noteId)
    {
        $user = Auth::user();

        $note = Note::findOrFail($noteId);

        $created = Favorite::create([
            'note_id' => $note ->id,
            'user_id' => $user->id
        ]);

        $service->create($user, $created);

        $user->favoritedNotes()->attach($noteId);
    }

    function unfavorite($noteId)
    {
        $user = Auth::user();

        $user->favoritedNotes()->detach($noteId);
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
}
