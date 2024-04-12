<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Modele;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Modele>
 */
class ModeleFactory extends Factory
{
    protected $model = Modele::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomModel' => $this->faker->word,
            'brand_id' => Brand::factory(),
            'engine' => $this->faker->randomElement(['Petrol', 'Hybrid', 'Electric']),
        ];
    }
}
