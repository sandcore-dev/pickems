<?php

namespace Database\Seeders;

use App\Models\Circuit;
use App\Models\Race;
use App\Models\Season;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Database\Seeder;

class RacesTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Season::exists() && !Circuit::exists()) {
            Race::factory()
                ->count(50)
                ->create();
            return;
        }

        $circuits = Circuit::all();

        try {
            Season::each(function (Season $season) use ($circuits) {
                Race::factory()
                    ->count(rand(18, 25))
                    ->create([
                        'season_id' => $season->id,
                        'circuit_id' => function () use ($circuits) {
                            return $circuits->random();
                        }
                    ]);
            });
        } /** @noinspection PhpRedundantCatchClauseInspection */ catch (QueryException $e) {
            // ignore
        }
    }
}
