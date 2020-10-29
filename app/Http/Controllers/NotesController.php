<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNoteRequest;
use App\Models\Tag;
use App\Models\Note;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Summary;
use App\Services\NoteService;

class NotesController extends Controller
{



    function create(NoteService $noteService, CreateNoteRequest $request)
    {
        $user = Auth::user();

        return $noteService->create($user, $request);
        
    }

    function delete($noteId)
    {

        $user = Auth::user();

        $note = $user->findOrFail($noteId);

        if($note == null){
            throw new AuthenticationException("${$noteId}への削除権限がありません");
        }

        $note->delete();
    }

    function timeline()
    {
        $user = Auth::user();

        return $user->timeline()->with(['author', 'tags', 'summary'])->simplePaginate(30);
    }

    function get($noteId)
    {
        return Note::withFavoriteCount()->with(['author', 'tags','summary'])->findOrFail($noteId);
    }

    public function searchByTag(Request $request){
        $builder = Note::with(['author', 'tags', 'summary']);

        $conditions = $request->input('conditions');

        foreach($conditions as $orConditions){
            $builder = $builder->whereIn('name', $orConditions);
        }

        return $builder->simplePaginate(30);
    }


}
