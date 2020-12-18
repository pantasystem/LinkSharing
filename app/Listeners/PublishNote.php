<?php

namespace App\Listeners;

use App\Events\NoteCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Note;
use App\Events\TimelineUpdated;


class PublishNote
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
        $query = $event->note->author()->first()->followers()->select('users.id');
        foreach($query->cursor() as $user){
            TimelineUpdated::dispatch($event->note, $user);
        }

    }
}
