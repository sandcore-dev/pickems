<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\Standing;
use App\Models\User;
use App\Models\Race;
use Illuminate\Database\Eloquent\Factories\Factory;

class StandingFactory extends Factory
{
    protected $model = Standing::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'league_id' => League::factory(),
            'race_id' => Race::factory(),
            'rank' => $this->faker->numberBetween(1, User::count()),
            'previous_id' => null,
            'picked' => $this->faker->randomNumber(3),
            'positions_correct' => $this->faker->randomNumber(2),
        ];
    }
}
