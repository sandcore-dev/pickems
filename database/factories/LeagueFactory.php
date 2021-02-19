<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeagueFactory extends Factory
{
    protected $model = League::class;

    public function definition(): array
    {
        return [
            'series_id' => Series::factory(),
            'name' => $this->faker->unique()->words(3, true),
            'access_token' => $this->faker->optional()->bothify('###???###'),
        ];
    }
}
