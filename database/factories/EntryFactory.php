<?php

namespace Database\Factories;

use App\Models\Entry;
use App\Models\Season;
use App\Models\Team;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    protected $model = Entry::class;

    public function definition()
    {
        return [
            'season_id' => Season::factory(),
            'team_id' => Team::factory(),
            'driver_id' => Driver::factory(),
            'car_number' => $this->faker->unique()->numberBetween(0, 99),
            'active' => $this->faker->boolean,
        ];
    }
}
