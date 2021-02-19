<?php

namespace Database\Factories;

use App\Models\Circuit;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CircuitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Circuit::class;

    public function definition(): array
    {
        return [
            'name' => function (array $attributes) {
                return $attributes['city'] . $this->faker->randomElement([' Raceway', ' Speedway', ' Circuit']);
            },
            'length' => $this->faker->numberBetween(3000, 25000),
            'city' => $this->faker->city,
            'country_id' => Country::factory(),
        ];
    }
}
