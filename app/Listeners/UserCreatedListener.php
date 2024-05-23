<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Tire;
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
            $randomModel = CarModel::query()->whereNotNull('id')->inRandomOrder()->first();
            if(!$randomModel){
                $randomBrand = Brand::query()->inRandomOrder()->first();
                if(!$randomBrand){
                    $randBrand = Brand::query()->create([
                        'name' => 'Ford',
                        'country' => 'US',
                    ]);
                    $randBrand->save();
                }

                $randomModel = CarModel::query()->create([
                    'nomModel' => 'Ranger',
                    'brand_id' => $randBrand->id,
                    'engine' => 'Hybrid',
                ]);
                $randomModel->save();
            }

            $randomTire = Tire::query()->inRandomOrder()->first();
            if(!$randomTire){
                $randomTire = Tire::query()->create([
                    'brand' => 'Michelin',
                    'model' => 'Random',
                    'type' => 'summer',
                ]);
                $randomTire->save();
            }

            $availableCar = Car::query()->create([
                'model_id' => $randomModel->id,
                'user_id' => $user->id,
                'color' => 'black', // Par défaut
                'front_tire_id' => $randomTire->id,
                'rear_tire_id' => $randomTire->id,
                'matricule' => generateMatricule(),
            ]);
        }
        return $availableCar;
    }
}
