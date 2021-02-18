<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Season;
use Illuminate\Database\Seeder;

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
