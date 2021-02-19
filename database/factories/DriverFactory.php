<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'surname_prefix' => $this->faker->optional(75)
                ->randomElement(['van', 'de', 'van de', 'van der', 'der', 'von', 'van den', 'den']),
            'last_name' => $this->faker->unique()->lastName,
            'country_id' => Country::factory(),
            'active' => $this->faker->boolean,
        ];
    }
}

