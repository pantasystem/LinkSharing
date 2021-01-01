<?php

namespace App\Services;

use App\Models\Note;
use App\Services\NotificationService;
use App\Models\User;
use App\Http\Requests\CreateNoteRequest;
use App\Models\Summary;
use App\Models\Tag;
use App\Events\NoteCreated;
use DB;


class NoteService
{

    public function create(User $user, CreateNoteRequest $request)
    {

        
        $summary = DB::transaction(function() use ($user, $request){
            $url = $request->only('url');

            $summary = Summary::where('url', '=', $url)->lockForUpdate()->first();
            if(!isset($summary)){
                $summary = new Summary($url);
                $summary->loadSummary();
                $summary->save();
                $summary->executeUpdateWords();
            }
            return $summary;
        });
        

        $reqTags = $request->input('tags');


        $createdNote = null;
        return \DB::transaction(function () use($user, $reqTags, $request, $summary){
            $createdNote = $user->notes()->create([
                'text' => $request->input('text'),
                'summary_id' => $summary->id
            ]);
    
    
            if(isset($reqTags)){
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
            }
            NoteCreated::dispatch($createdNote);
            return Note::withDetail($user)->findOrFail($createdNote->id);
        });
        


        
        
    }


}