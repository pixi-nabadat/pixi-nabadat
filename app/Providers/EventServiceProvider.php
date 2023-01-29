<?php

namespace App\Providers;

use App\Events\PushEvent;
use App\Events\OrderCreated;
use App\Listeners\changeOrderDependencies;
use App\Listeners\SendChangeOrderStatusNotification;
use App\Listeners\SendOrderCreatedNotification;
use App\Listeners\SendReservationCreatedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            changeOrderDependencies::class
        ],
        PushEvent::class => [
            SendOrderCreatedNotification::class,
            SendChangeOrderStatusNotification::class,
            SendReservationCreatedNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
