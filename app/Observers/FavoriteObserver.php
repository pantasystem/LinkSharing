<?php

namespace App\Observers;

use App\Models\Favorite;
use App\Events\Favorited;

class FavoriteObserver
{
    /**
     * Handle the favorite "created" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function created(Favorite $favorite)
    {
        //
        Favorited::dispatch($created);

    }

    /**
     * Handle the favorite "updated" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function updated(Favorite $favorite)
    {
        //
    }

    /**
     * Handle the favorite "deleted" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function deleted(Favorite $favorite)
    {
        //
    }

    /**
     * Handle the favorite "restored" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function restored(Favorite $favorite)
    {
        //
    }

    /**
     * Handle the favorite "force deleted" event.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return void
     */
    public function forceDeleted(Favorite $favorite)
    {
        //
    }
}
