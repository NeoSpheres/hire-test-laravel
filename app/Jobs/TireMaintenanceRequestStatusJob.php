<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TireMaintenanceRequestStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * You may ask `why I send the IDs inside the constructor instead of the whole model?`. Answer: RabbitMQ has a restriction about the size of messages. A a similar problem can be found in AWS SQS driver as well. It's safer to send IDs and then fetch the models inside the job handler.
     */
    public function __construct(public int $tireMaintenanceRequestId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Nothing to do here...
    }
}
