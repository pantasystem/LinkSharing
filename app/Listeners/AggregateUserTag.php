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
        //
    }
}
