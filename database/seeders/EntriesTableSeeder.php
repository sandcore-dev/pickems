<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Entry;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class EntriesTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Season::exists() && !Team::exists() && !Driver::exists()) {
            Entry::factory()
                ->count(50)
                ->create();
            return;
        }

        $seasons = Season::all();
        $teams = Team::all();
        $drivers = Driver::all();

        try {
            Entry::factory()
                ->count(50)
                ->create([
                    'season_id' => function () use ($seasons) {
                        return $seasons->random();
                    },
                    'team_id' => function () use ($teams) {
                        return $teams->random();
                    },
                    'driver_id' => function () use ($drivers) {
                        return $drivers->random();
                    },
                ]);
        }  catch (QueryException $e) {
            // ignore
        }
    }
}
