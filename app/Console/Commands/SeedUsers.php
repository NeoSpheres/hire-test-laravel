<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\Car;
use App\Models\Brand;
use App\Models\Modele;
use App\Events\UserCreated;


class SeedUsers extends Command
{
    protected $signature = 'seed:users {count?}';

    protected $description = 'Floods the database with users';

    public function handle()
    {
        $this->info('Creating users...');

        /*$initialUsersCount = User::count();

        $usersToReach = $this->argument('count') ?? 10;

        if (!is_numeric($usersToReach) || $usersToReach <= 0) {
            $this->error('Invalid count provided. Please provide a positive integer.');
            return;
        }

        $usersToInsert = $usersToReach;

        if ($initialUsersCount > 0) {
            $usersToInsert -= $initialUsersCount;
        }

        for ($i = 1; $i <= $usersToInsert; $i++) {
            $user = User::factory()->create();
            event(new UserCreated($user));
        }

        $this->info('Users created successfully!');*/

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
