<?php

namespace Database\Factories;

use App\Models\Race;
use App\Models\Season;
use App\Models\Circuit;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaceFactory extends Factory
{
    protected $model = Race::class;

    public function definition(): array
    {
        $race_day = strtotime('next Sunday', $this->faker->unixTime());
        $weekend_start = strtotime('-3 days', $race_day);

        return [
            'season_id' => Season::factory(),
            'circuit_id' => Circuit::factory(),
            'name' => 'Grand Prix of ' . $this->faker->country,
            'weekend_start' => date('Y-m-d H:i:s', $weekend_start),
            'race_day' => date('Y-m-d', $race_day),
        ];
    }
}
