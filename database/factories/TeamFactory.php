<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company . ' Team',
            'country_id' => Country::factory(),
            'active' => $this->faker->boolean,
        ];
    }
}
