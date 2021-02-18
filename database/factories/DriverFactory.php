<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'country_id' => Country::factory(),
            'active' => $this->faker->boolean,
        ];
    }
}

