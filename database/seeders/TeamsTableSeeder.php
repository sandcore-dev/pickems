<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Country::exists()) {
            Team::factory()
                ->count(11)
                ->create();
            return;
        }

        $countries = Country::all();

        Team::factory()
            ->count(11)
            ->create([
                'country_id' => function () use ($countries) {
                    return $countries->random();
                }
            ]);
    }
}
