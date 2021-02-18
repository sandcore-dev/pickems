<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\League;
use App\User;

class LeagueUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$leagues	= League::all();
    	$users		= User::all();

    	for( $i = 0; $i < 50; $i++ )
    	{
    		$leagues->random()->users()->syncWithoutDetaching( $users->random()->id );
    	}
    }
}
