<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class SeasonsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Series::exists()) {
            Season::factory()
                ->count(25)
                ->create();

            return;
        }

        $series = Series::all();

        try {
            Season::factory()
                ->count(25)
                ->create([
                    'series_id' => function () use ($series) {
                        return $series->random();
                    },
                ]);
        } catch (QueryException $e) {
            // ignore
        }
    }
}
