<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
use App\Models\TireMaintenance\TireMaintenanceRequest;
use App\Models\User;
use App\Notifications\TireMaintenance\UserMaintenanceRequestCancelledNotification;
use App\Notifications\TireMaintenance\UserMaintenanceRequestCompletedNotification;
use App\Notifications\TireMaintenance\UserMaintenanceRequestInProgressNotification;
use App\Notifications\TireMaintenance\UserMaintenanceRequestSubmittedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserTireMaintenanceRequestStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * You may ask `why I send the IDs inside the constructor instead of the whole model?`. Answer: RabbitMQ has a restriction about the size of messages. A a similar problem can be found in AWS SQS driver as well. It's safer to send IDs and then fetch the models inside the job handler.
     */
    public function __construct(public int $userId, public int $tireMaintenanceRequestId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::findOrFail($this->userId);
        $tireMaintenanceRequest = TireMaintenanceRequest::findOrFail($this->tireMaintenanceRequestId);

        match ($tireMaintenanceRequest->status) {
            TireMaintenanceRequestStatusEnum::PENDING => $user->notify(new UserMaintenanceRequestSubmittedNotification()),
            TireMaintenanceRequestStatusEnum::IN_PROGRESS => $user->notify(new UserMaintenanceRequestInProgressNotification()),
            TireMaintenanceRequestStatusEnum::CANCELLED => $user->notify(new UserMaintenanceRequestCancelledNotification()),
            TireMaintenanceRequestStatusEnum::COMPLETED => $user->notify(new UserMaintenanceRequestCompletedNotification()),
            default => null
        };
    }
}
