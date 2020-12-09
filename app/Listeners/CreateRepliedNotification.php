<?php

namespace App\Listeners;

use App\Events\Replied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateRepliedNotification
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
     * @param  Replied  $event
     * @return void
     */
    public function handle(Replied $event)
    {
        //
    }
}
