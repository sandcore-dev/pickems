<?php

namespace Database\Factories;

use App\Models\League;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeagueFactory extends Factory
{
    protected $model = League::class;

    public function definition()
    {
        return [
            'name'	=> $this->faker->unique()->words( 3, true ),
        ];
    }
}
