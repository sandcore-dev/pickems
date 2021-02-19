<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,

            SeriesTableSeeder::class,
            SeasonsTableSeeder::class,

            CountriesTableSeeder::class,
            CircuitsTableSeeder::class,

            DriversTableSeeder::class,
            TeamsTableSeeder::class,

            EntriesTableSeeder::class,
            RacesTableSeeder::class,

            LeaguesTableSeeder::class,

            PicksTableSeeder::class,
            ResultsTableSeeder::class,
            StandingsTableSeeder::class,
        ]);
    }
}
