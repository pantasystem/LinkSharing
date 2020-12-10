<?php

namespace App\Listeners;

use App\Events\Followed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationService;

class CreateFollowedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        //
        $this->notificationService = $notificationService;
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
        $publisher = $event->followingUser->user()->first();

        $this->notificationService->create($publisher, $event->followingUser);
    }
}
