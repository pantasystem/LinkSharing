<?php

namespace App\Listeners;

use App\Events\Followed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EchoFollowed
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
     * @param  Followed  $event
     * @return void
     */
    public function handle(Followed $event)
    {
        //
    }
}
