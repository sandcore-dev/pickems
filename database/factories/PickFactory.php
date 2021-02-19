<?php

namespace Database\Factories;

use App\Models\Pick;
use App\Models\Race;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PickFactory extends Factory
{
    protected $model = Pick::class;

    public function definition(): array
    {
        return [
            'race_id' => Race::factory(),
            'entry_id' => Entry::factory(),
            'user_id' => User::factory(),
            'rank' => function (array $attributes) {
                return Pick::where('race_id', $attributes['race_id'])
                        ->where('user_id', $attributes['user_id'])
                        ->max('rank') + 1;
            },
            'carry_over' => 0,
        ];
    }
}
