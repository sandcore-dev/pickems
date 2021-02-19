<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\Pick;
use App\Models\Race;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;

class PicksTableSeeder extends Seeder
{
    public function run(Generator $faker): void
    {
        if (!Race::exists() && !Entry::exists() && !User::exists()) {
            Pick::factory()
                ->count(500)
                ->create();
            return;
        }

        Race::with('season.entries')
            ->has('season.entries')
            ->each(function (Race $race) use ($faker) {
                $entries = $race->season->entries;

                User::each(function (User $user) use ($faker, $race, $entries) {
                    if ($faker->boolean(10)) {
                        return;
                    }

                    Pick::factory()
                        ->create([
                            'race_id' => $race,
                            'user_id' => $user,
                            'entry_id' => $entries->random(),
                        ]);
                });
            });
    }
}
