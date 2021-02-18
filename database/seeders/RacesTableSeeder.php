<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Race;
use App\Season;

class RacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Race::factory()
            ->times(Season::count() * 20)
            ->create();
    }
}
