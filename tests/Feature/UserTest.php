<?php

namespace Tests\Feature;

use App\Events\UserCreated;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Modele;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */

    public function test_if_user_is_created(): void
    {
        // Créer un utilisateur
        $user = User::factory()->create([
            'name' => 'user_test1',
            'email' => 'user_test1@test.fr',
            'password' => '12345678'
        ]);
        event(new UserCreated($user));


        // Vérifier que l'utilisateur a été créé avec succès
        $this->assertNotNull($user);

        // Vérifier qu'une voiture est associée à l'utilisateur
        $car = Car::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($car);
    }

    public function test_if_10_user_is_created(): void
    {
        // Créer 10 utilisateurs avec des voitures associées
        User::factory()->count(10)->create()->each(function ($user) {
            event(new UserCreated($user));

            // Vérifier que l'utilisateur a été créé avec succès
            $this->assertNotNull($user);
        });

        // Vérifier que chaque utilisateur a une voiture associée
        $users = User::all();
        foreach ($users as $user) {
            $car = Car::query()->where('user_id', $user->id)->first();
            $this->assertNotNull($car);
        }

    }


}
