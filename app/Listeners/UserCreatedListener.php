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


        /*
                if (!$user->car) {

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
                    }*/


        $user = $event->user;

<<<<<<< HEAD
// Vérifiez si une voiture est disponible pour l'affectation
        $availableCar = Car::whereNull('user_id')->inRandomOrder()->first();
=======
        if(!$user->car){
            $randomPassword = Str::random(10);
        // Récupérer les voitures disponibles et choisir la première
        $availableCar = Car::query()->whereNull('user_id')->first();
>>>>>>> 123a6a7de7714489254e4a3587357f3e8b33b3ab

        if ($availableCar) {
            // Si une voiture est disponible, associez-la à l'utilisateur
            $availableCar->user()->associate($user);
            $availableCar->save();
<<<<<<< HEAD
        } else {
            // Si aucune voiture n'est disponible, créez une nouvelle voiture avec un modèle par défaut
            $car = new Car([
                'id' => 1, // Remplacez par l'ID du modèle de voiture par défaut
                'color' => 'blue', // Couleur de la voiture par défaut
                'matricule' => 'YB-276-IH', // Plaque d'immatriculation de la voiture par défaut
            ]);
            $user->car()->save($car);
=======
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
>>>>>>> 123a6a7de7714489254e4a3587357f3e8b33b3ab
        }
    }
}
