<?php

namespace App\Observers;

use App\Models\FollowingUser;
use App\Events\Followed;


class FollowingUserObserver
{
    /**
     * Handle the FollowingUser "created" event.
     *
     * @param  \App\Models\FollowingUser  $followingUser
     * @return void
     */
    public function created(FollowingUser $followingUser)
    {
        Followed::dispatch($followingUser);
    }

    /**
     * Handle the FollowingUser "updated" event.
     *
     * @param  \App\Models\FollowingUser  $followingUser
     * @return void
     */
    public function updated(FollowingUser $followingUser)
    {
        //
    }

    /**
     * Handle the FollowingUser "deleted" event.
     *
     * @param  \App\Models\FollowingUser  $followingUser
     * @return void
     */
    public function deleted(FollowingUser $followingUser)
    {
        //
    }

    /**
     * Handle the FollowingUser "restored" event.
     *
     * @param  \App\Models\FollowingUser  $followingUser
     * @return void
     */
    public function restored(FollowingUser $followingUser)
    {
        //
    }

    /**
     * Handle the FollowingUser "force deleted" event.
     *
     * @param  \App\Models\FollowingUser  $followingUser
     * @return void
     */
    public function forceDeleted(FollowingUser $followingUser)
    {
        //
    }
}
