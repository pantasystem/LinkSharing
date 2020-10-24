<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateNoteRequest;
use App\Models\Tag;
use App\Models\Note;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Summary;

class NotesController extends Controller
{



    function create(CreateNoteRequest $request)
    {
        $user = Auth::user();

        $url = $request->only('url');
        
        $summary = Summary::where('url', '=', $url)->first();
        if(isset($summary)){
            $summary = new Summary($url);
            $summary->save();
        }

        $note = new Note;
        $note->text = $request->only('text');
        $note->associate($user);
        $note->associate($summary);

        $createdNote = $note->save();

        $reqTags = $request->only('tags');

        foreach($reqTags as $reqTag){
            $tag = Tag::firstOrCreate([
                'name' => $reqTag
            ]);

            $tag->notes()->attach($createdNote);
        }


        return Note::with(['author', 'tags', 'summary'])->findOrFail($createdNote->id);
        
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



}
