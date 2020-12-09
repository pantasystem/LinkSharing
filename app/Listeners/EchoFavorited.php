<?php

namespace App\Listeners;

use App\Events\Favorited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EchoFavorited
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
     * @param  Favorited  $event
     * @return void
     */
    public function handle(Favorited $event)
    {
        //
    }
}
