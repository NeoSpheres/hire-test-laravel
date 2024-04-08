<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SeedUsers extends Command
{
    protected $signature = 'seed:users {count?}';

    protected $description = 'Floods the database with users';

    public function handle()
    {
        $this->info('Creating users...');

        $initialUsersCount = User::count();

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
            User::factory()->create();
        }

        $this->info('Users created successfully!');
    }

}
