<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class SeedUsers extends Command
{
    protected $signature = 'seed:users';
    protected $max_users = 2550;

    public function handle()
    {
        $num_users = 100000;
        $batch_size = 500;

        try {
            $current_users_count = DB::table('users')->count();

            $remaining_users = $this->max_users - $current_users_count;

            // Condition pour vérifier si remaining_users < batch_size
            if ($remaining_users < $batch_size) {
                $batch_size = $remaining_users;
            }

            // vérifier si $batch_size > 0 sinn stop
            if ($batch_size > 0) {
                for ($i = 0; $i < $num_users; $i += $batch_size) {
                    $response = Http::withoutVerifying()->get("https://randomuser.me/api/?results=$batch_size");
                    $data = $response->json()['results'];
                    $users = [];
                    foreach ($data as $user) {
                        $name = $user['name']['first'] . ' ' . $user['name']['last'];
                        $email = $user['email'];
                        $password = Str::random(16);

                        // vérifier si email existe deja dans la database
                        if (!$this->emailExists($email)) {
                            $users[] = [
                                'name' => $name,
                                'email' => $email,
                                'password' => Hash::make($password),
                            ];
                        }
                    }

                    DB::table('users')->insert($users);
                }
            }

            $this->info("User generation completed successfully!");
        } catch (Exception $e) {
            $this->error("Error while calling the RandomUser API: " . $e->getMessage());
        }
    }


    // vérifier email dans la database
    private function emailExists($email)
    {
        return DB::table('users')->where('email', $email)->exists();
    }
}
