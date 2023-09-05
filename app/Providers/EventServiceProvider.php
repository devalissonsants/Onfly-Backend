<?php

namespace App\Providers;

use App\Events\OutlayNotificationUser;
use App\Listeners\SendMailOutlayCreated;
use App\Models\Outlay;
use App\Observers\OutlayObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        OutlayNotificationUser::class => [
            SendMailOutlayCreated::class,
        ],
    ];

    public function boot(): void
    {
        Outlay::observe(OutlayObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
