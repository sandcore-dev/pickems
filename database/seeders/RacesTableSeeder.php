<?php

namespace Database\Seeders;

use App\Models\Race;
use App\Models\Season;
use Illuminate\Database\Seeder;

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
