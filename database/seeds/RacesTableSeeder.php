<?php

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
    	factory( Race::class, Season::count() * 20 )->create();
    }
}
