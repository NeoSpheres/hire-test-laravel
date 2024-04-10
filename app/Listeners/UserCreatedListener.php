<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Brand;
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
            $randomPassword = Str::random(10);
        // Récupérer les voitures disponibles et choisir la première
        $availableCar = Car::whereNull('user_id')->first();

        if ($availableCar) {
            // Associer à l'utilisateur la voiture trouvée
            $availableCar->user_id = $user->id;
            $availableCar->save();
        } else {
            // Sinon, créer une nouvelle voiture
            $brand = Brand::create([
                'name' => '',
                'country' => ''
            ]);

            $model =

            $car = Car::create([
                'brand_id' => $brand->id,
                //'model_id' => $model->id,
                'user_id' => $user->id,
                'color' => 'black', // Par défaut
                'matricule' => generateMatricule(),
            ]);
        }

        /*if(!$user->car){
            $car = Car::create([
                'user_id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'password'=>bcrypt($randomPassword),

            ]);

            $user->car()->associate($car);
            $user->save();
        }*/
    }
}
