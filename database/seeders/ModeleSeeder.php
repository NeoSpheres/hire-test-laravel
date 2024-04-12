<?php

namespace Database\Seeders;

use App\Models\Modele;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModeleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modele::factory()->count(2)->create();

    }
}
