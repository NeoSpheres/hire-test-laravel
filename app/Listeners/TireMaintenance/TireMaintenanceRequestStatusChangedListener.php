<?php

declare(strict_types=1);

namespace App\Listeners\TireMaintenance;

use App\Events\TireMaintenance\TireMaintenanceRequestCancelledEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestCompletedEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestInProgressEvent;
use App\Events\TireMaintenance\TireMaintenanceRequestSubmittedEvent;
use App\Jobs\NotifyUserTireMaintenanceRequestStatusJob;
use App\Jobs\TireMaintenanceRequestStatusJob;

class TireMaintenanceRequestStatusChangedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TireMaintenanceRequestCancelledEvent|TireMaintenanceRequestCompletedEvent|TireMaintenanceRequestInProgressEvent|TireMaintenanceRequestSubmittedEvent $event): void
    {
        // Notify the user about the status change of their tire maintenance request
        dispatch(new NotifyUserTireMaintenanceRequestStatusJob($event->model->user->id, $event->model->id));

        // Additionally queue a job to the `RabbitMQ` driver. I was lazy and didn't setup the driver to the app, but in case it was setup, just change the driver name for the job.
        dispatch(
            (new TireMaintenanceRequestStatusJob($event->model->id))
                ->onConnection('database')
                ->onQueue('maintenances')
        );
    }
}
