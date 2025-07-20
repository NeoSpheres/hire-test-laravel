<?php

namespace Database\Factories;

use App\Models\CarModel;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarModel>
 */
class CarModelFactory extends Factory
{
    protected $model = CarModel::class;

    public function definition(): array
    {
        return [
            'nomModel' => $this->faker->word,
            'brand_id' => Brand::factory()
        ];
    }
}
