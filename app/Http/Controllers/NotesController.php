<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNoteRequest;
use App\Models\Tag;
use App\Models\Note;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{



    function create(CreateNoteRequest $request)
    {
        $user = Auth::user();
        
        $createdNote = $user->notes()->create($request->only(['url', 'text']));

        $reqTags = $request->only('tags');

        foreach($reqTags as $reqTag){
            $tag = Tag::firstOrCreate([
                'name' => $reqTag
            ]);

            $tag->notes()->attach($createdNote);
        }


        return Note::with(['author', 'tags'])->find($createdNote->id);
        
    }

    function delete($noteId)
    {

        $user = Auth::user();

        $note = $user->find($noteId);

        if($note == null){
            throw new AuthenticationException("${$noteId}への削除権限がありません");
        }

        $note->delete();
    }

    function timeline()
    {
        $user = Auth::user();

        return $user->timeline()->with(['author', 'tags'])->paginate(30);
    }

    function get($noteId)
    {
        return Note::withFavoriteCount()->with(['author', 'tags'])->find($noteId);
    }



}
