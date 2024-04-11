<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Modele;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

include_once app_path().'/Helpers/MatriculeHelper.php';

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
    public function handle(UserCreated $event)
    {
        $user = $event->user;

        if(!$user->car){
            $randomPassword = Str::random(10);
        // Récupérer les voitures disponibles et choisir la première
        $availableCar = Car::query()->whereNull('user_id')->first();

        if ($availableCar) {
            // Associer à l'utilisateur la voiture trouvée
            $availableCar->user_id = $user->id;
            $availableCar->save();
        }

        return $availableCar;

        /*else {
            // Sinon, créer une nouvelle voiture
            $brand = Brand::query()->firstOrCreate([
                'name' => 'NomDeLaMarque',
                'country' => 'Pays'
            ]);

            $model = Modele::query()->firstOrCreate([
                'nomModel' => 'NomDuModele',
                'idBrand' => $brand->id,
                'engine' => 'TypeDuMoteur'
            ]);


            $car = Car::create([
                'model_id' => $model->id,
                'user_id' => $user->id,
                'color' => 'black', // Par défaut
                'matricule' => generateMatricule(),
            ]);
            $car->save();
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
