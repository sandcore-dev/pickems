<?php

namespace Database\Factories;

use App\Standing;
use App\User;
use App\Race;
use Illuminate\Database\Eloquent\Factories\Factory;

class StandingFactory extends Factory
{
    protected $model = Standing::class;

    public function definition()
    {
        $usersWithLeagues = User::has('leagues')->get();

        do {
            $leagueUserId = $usersWithLeagues->random()->leagues->random()->id;
            $raceId = Race::all()->random()->id;
        } while (!Standing::where('league_user_id', $leagueUserId)->where('race_id', $raceId)->get()->isEmpty());

        return [
            'league_user_id' => $leagueUserId,
            'race_id' => Race::factory(),
            'rank' => $this->faker->numberBetween(1, User::count()),
            'previous_id' => null,
            'picked' => $this->faker->randomNumber(3),
            'positions_correct' => $this->faker->randomNumber(2),
        ];
    }
}
