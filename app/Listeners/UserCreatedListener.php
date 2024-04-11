<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Modele;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

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
        $this->assignCarToUser($user);
    }
    public function assignCarToUser($user)
    {
        if (!$user->car) {

            // Récupérer les voitures disponibles et choisir la première
            $availableCar = Car::whereNull('user_id')->first();

            if ($availableCar) {
                // Associer à l'utilisateur la voiture trouvée
                $availableCar->user_id = $user->id;
                $availableCar->save();
            } else {
                // Récupérer un ID de modèle aléatoire
                $randomBrand = Brand::inRandomOrder()->value('id');
                $randomModelId = Modele::inRandomOrder()->value('id');
                $randomColor = generateRandomColor();

                // Créer une nouvelle voiture avec l'ID de modèle aléatoire
                $car = Car::create([
                    'brand_id' => $randomBrand,
                    'model_id' => $randomModelId,
                    'user_id' => $user->id,
                    'color' => $randomColor, // Par défaut
                    'matricule' => generateMatricule(),
                ]);
            }
        }
    }
}


     /*  $user = $event->user;

        $availableCar = Car::whereNull('user_id')->inRandomOrder()->first();
        if (!$user->car) {
            $randomPassword = Str::random(10);
            // Récupérer les voitures disponibles et choisir la première
            $availableCar = Car::query()->whereNull('user_id')->first();

            if ($availableCar) {
                // Si une voiture est disponible, associez-la à l'utilisateur
                $availableCar->user()->associate($user);
                $availableCar->save();
            } else {
                // Si aucune voiture n'est disponible, créez une nouvelle voiture avec un modèle par défaut
                $car = new Car([
                    'id' => 1, // Remplacez par l'ID du modèle de voiture par défaut
                    'color' => 'blue', // Couleur de la voiture par défaut
                    'matricule' => 'YB-276-IH', // Plaque d'immatriculation de la voiture par défaut
                ]);
                $user->car()->save($car);
            }

            return $availableCar;
        }
    }
}*/

        // Récupérer les voitures disponibles et choisir la première
        $availableCar = Car::query()->whereNull('user_id')->first();

        if ($availableCar) {
            // Associer à l'utilisateur la voiture trouvée
            $availableCar->user_id = $user->id;
        } else {
            $randomModel = Modele::query()->whereNotNull('id')->inRandomOrder()->first();

            $availableCar = Car::query()->create([
                'model_id' => $randomModel->id,
                'user_id' => $user->id,
                'color' => 'black', // Par défaut
                'matricule' => generateMatricule(),
            ]);

            /* Sinon, créer une nouvelle voiture
            $brand = Brand::query()->firstOrCreate([
                'name' => 'NomDeLaMarque',
                'country' => 'Pays'
            ]);

            $model = Modele::query()->firstOrCreate([
                'nomModel' => 'NomDuModele',
                'idBrand' => $brand->id,
                'engine' => 'TypeDuMoteur'
            ]);*/
        }
        $availableCar->save();

        return $availableCar;



