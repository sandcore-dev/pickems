<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\Race;
use App\Models\Result;
use Illuminate\Database\Seeder;

class ResultsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Race::exists() && !Entry::exists()) {
            Result::factory()
                ->count(200)
                ->create();
            return;
        }

        Entry::with('season.races')
            ->each(function (Entry $entry) {
                $entry->season->races->each(function (Race $race) use ($entry) {
                    Result::factory()
                        ->create([
                            'race_id' => $race,
                            'entry_id' => $entry,
                        ]);
                });
            });
    }
}
