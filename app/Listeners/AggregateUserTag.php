<?php

namespace App\Listeners;

use App\Events\NoteCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $user = $note->user()->first();
        DB::transaction(function() use ($note){
            $noteIds = $note->tags()->pluck('id');
            $useTagAgg = UseTagAggregate::where('tag_id', '=', $id)->firstOrNew();
            $noteIds->each(function($id){
                $useTagAgg->increment();
                $useTagAgg->save();
            });
        });
    }
}
