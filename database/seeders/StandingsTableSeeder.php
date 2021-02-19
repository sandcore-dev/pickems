<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Race;
use App\Models\Standing;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Seeder;

class StandingsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::exists() && !League::exists() && !Race::exists()) {
            Standing::factory()
                ->count(100)
                ->create();
            return;
        }

        $races = Race::all();

        User::with('leagues')
            ->each(function (User $user) use ($races) {
                $user->leagues->each(function (League $league) use ($races, $user) {
                    try {
                        Standing::factory()
                            ->create([
                                'user_id' => $user,
                                'league_id' => $league,
                                'race_id' => $races->random(),
                            ]);
                    } catch (QueryException $e) {
                        // ignore
                    }
                });
            });
    }
}
