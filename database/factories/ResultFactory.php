<?php

namespace Database\Factories;

use App\Result;
use App\Race;
use App\Entry;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResultFactory extends Factory
{
    protected $model = Result::class;

    public function definition()
    {
        return [
            'rank' => $this->faker->numberBetween(1, 22),
            'race_id' => Race::factory(),
            'entry_id' => Entry::factory(),
        ];
    }
}
