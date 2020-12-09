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
            'App\Listeners\EchoReplied',
        ],
        'App\Events\Favorited' =>[
            'App\Listeners\CreateFavoritedNotification',
            'App\Listeners\EchoFavorited'
        ],
        'App\Events\Followed' => [
            'App\Listeners\CreateFollowedNotification',
            'App\Listeners\EchoFollowed'
        ],
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
