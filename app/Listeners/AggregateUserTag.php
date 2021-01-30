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
        DB::transaction(function() use ($note, $user){
            $tagIds = $note->tags()->pluck('id');
            $tagIds->each(function($tagId) use ($user){
                $useTagAgg = UseTagAggregate::firstOrNew([
                    'user_id' => $user->id,
                    'tag_id' => $tagId
                ]);

                $useTagAgg->increment();
                $useTagAgg->save();
            });
        });;
    }
}
