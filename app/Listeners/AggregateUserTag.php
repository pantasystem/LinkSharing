<?php

namespace App\Listeners;

use App\Events\NoteCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\UsingTagCount;
use DB;

class AggregateUserTag
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NoteCreated  $event
     * @return void
     */
    public function handle(NoteCreated $event)
    {
        // ユーザーが利用しているタグを集計します。
        $note = $event->note;
        $user = $note->author()->first();
        DB::transaction(function() use ($note, $user){
            $tagIds = $note->tags()->pluck('tags.id');
            foreach($tagIds as $tagId){
                $useTagAgg = UsingTagCount::firstOrNew([
                    'user_id' => $user->id,
                    'tag_id' => $tagId
                ]);

                //$useTagAgg->increment('count', 1);
                if(is_null($useTagAgg->count)){
                    $useTagAgg->count = 0;
                }
                $useTagAgg->count = $useTagAgg->count + 1;
                $useTagAgg->save();
            }
            
        });;
    }
}
