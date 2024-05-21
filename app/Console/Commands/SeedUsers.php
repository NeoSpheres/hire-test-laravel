<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;
use App\Events\UserCreated;


class SeedUsers extends Command
{
    protected $signature = 'seed:users {count?}';

    protected $description = 'Floods the database with users';

    public function handle()
    {
        $this->info('Creating users...');

        $count = $this->argument('count');

        for ($i = 0; $i < $count; $i++) {
            // Créer un utilisateur
            $user = User::factory()->create([
                'password' => Hash::make('password'), // Changez 'password' en mot de passe souhaité
            ]);
            event(new UserCreated($user));
        }

        $this->info("$count users created successfully!");
    }
}
