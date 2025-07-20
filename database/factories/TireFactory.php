<?php

namespace Database\Factories;

use App\Models\Tire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tire>
 */
class TireFactory extends Factory
{
    protected $model = Tire::class;

    public function definition(): array
    {
        return [
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'quantity' => 10,
            'type' => $this->faker->randomElement(['summer', 'winter', 'all-season']),
        ];
    }
}
