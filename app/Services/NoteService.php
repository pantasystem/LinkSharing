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
        if(!isset($summary)){
            $summary = new Summary($url);
            $summary->loadSummary();
            $summary->save();
        }

        $reqTags = $request->input('tags');


        $createdNote = null;
        return \DB::transaction(function () use($user, $reqTags, $request, $summary){
            $createdNote = $user->notes()->create([
                'text' => $request->input('text'),
                'summary_id' => $summary->id
            ]);
    
    
    
            foreach($reqTags as $reqTag){
                $trimedTag = trim($reqTag);
                if(!empty($trimedTag)){
                    $tag = Tag::where('name', '=', $reqTag)->first();
                    if(!$tag){
                        $tag = Tag::create(['name' => $reqTag]);
                    }
        
                    $tag->notes()->attach($createdNote);
                }
                
            }
            return Note::with(['author', 'tags', 'summary'])->findOrFail($createdNote->id);
        });
        


        
        
    }


}