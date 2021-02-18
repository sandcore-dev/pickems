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

    public function definition()
    {
        $usersWithLeagues = User::has('leagues')->get();
        $leagueUserId = $usersWithLeagues->random()->leagues->random()->id;

        return [
            'race_id' => Race::factory(),
            'entry_id' => Entry::factory(),
            'league_user_id' => $leagueUserId,
            'rank' => function (array $attributes) {
                return Pick::where('race_id', $attributes['race_id'])
                        ->where('league_user_id', $attributes['league_user_id'])
                        ->max('rank') + 1;
            },
            'carry_over' => 0,
        ];
    }
}
