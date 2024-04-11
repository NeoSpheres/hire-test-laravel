<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Modele;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

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
        $this->assignCarToUser($user);
    }
    public function assignCarToUser($user)
    {
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
        }

        $availableCar->save();

        return $availableCar;

        /*if (!$user->car) {

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
        }*/
    }
}
