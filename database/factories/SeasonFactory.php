<?php

namespace Database\Factories;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeasonFactory extends Factory
{
    protected $model = Season::class;

    public function definition()
    {
        $start_year = (int)$this->faker->year();
        $end_year = $this->faker->boolean
            ? $start_year
            : $start_year + 1;

        return [
            'series_id' => Series::factory(),
            'start_year' => $start_year,
            'end_year' => $end_year,
        ];
    }
}

