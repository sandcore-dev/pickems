<?php

namespace Database\Factories;

use App\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company . ' Championship',
        ];
    }
}
