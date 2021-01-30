<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /*Registered::class => [
            SendEmailVerificationNotification::class,
        ],*/
        'App\Events\Replied' => [
            'App\Listeners\CreateRepliedNotification',
        ],
        'App\Events\Favorited' =>[
            'App\Listeners\CreateFavoritedNotification',
        ],
        'App\Events\Followed' => [
            'App\Listeners\CreateFollowedNotification',
        ],
        'App\Events\Notified' => [],
        'App\Events\NoteCreated' => [
            'App\Listeners\PublishNote',
            'App\Listeners\AggregateUserTag'
        ],
        'App\Events\TimelineUpdated' => []
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
