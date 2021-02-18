<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\League;
use App\Season;

class LeagueSeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$leagues	= League::all();
    	$seasons	= Season::all();

    	for( $i = 0; $i < 50; $i++ )
    	{
    		$leagues->random()->seasons()->syncWithoutDetaching( $seasons->random()->id );
    	}
    }
}
