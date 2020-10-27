<?php

namespace App\Services;

use App\Models\Note;
use App\Services\NotificationService;
use App\Models\User;
use App\Http\Requests\CreateNoteRequest;
use App\Models\Summary;
use App\Models\Tag;


class NoteService
{

    public function create(User $user, CreateNoteRequest $request)
    {

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


}