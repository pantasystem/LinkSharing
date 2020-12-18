<?php

namespace App\Listeners;

use App\Events\Replied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\NotificationService;
use App\Events\Notified;


class CreateRepliedNotification
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
     * @param  Replied  $event
     * @return void
     */
    public function handle(Replied $event)
    {
        //
        $publisher = $event->comment->author()->first();

        $notification = $notificationService->create($publisher,  $event->comment);
        if(isset($notification)){
            Notified::dispatch($notification);
        }
    }
}
