<?php

namespace App\Listeners;

use App\Events\Favorited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationService;


class CreateFavoritedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
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
        $notification = $this->notificationService->create($event->publisher, $event->favorite);
    }
}
