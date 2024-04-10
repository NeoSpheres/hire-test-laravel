<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Car;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCreatedListener
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
    public function handle(UserCreated $event): void
    {
        $user = $event->user;

        if(!$user->car){
            $car = Car::create([
                'user_id'=>$user->id,

            ]);

            $user->car()->associate($car);
            $user->save();
        }
    }
}
