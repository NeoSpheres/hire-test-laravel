<?php

namespace App\Providers;

use App\Events\TireMaintenance\TireMaintenanceRequestCancelledEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestCompletedEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestInProgressEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestSubmittedEvent;
use App\Listeners\TireMaintenance\TireMaintenanceRequestStatusChangedListener;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     */
    protected $listen = [
        'App\Events\UserCreated' => [
            'App\Listeners\UserCreatedListener',
        ],
        // Yes, I know it could be done the other way around -> having a listener subscribed to events.
        TireMaintenanceRequestSubmittedEvent::class => [
            TireMaintenanceRequestStatusChangedListener::class
        ],
        TireMaintenanceRequestInProgressEvent::class => [
            TireMaintenanceRequestStatusChangedListener::class
        ],
        TireMaintenanceRequestCompletedEvent::class => [
            TireMaintenanceRequestStatusChangedListener::class
        ],
        TireMaintenanceRequestCancelledEvent::class => [
            TireMaintenanceRequestStatusChangedListener::class
        ]
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
