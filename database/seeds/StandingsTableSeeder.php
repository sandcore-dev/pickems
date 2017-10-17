<?php

use Illuminate\Database\Seeder;

use App\Standing;

class StandingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for( $i = 0; $i < 100; $i++ )
	    	factory( Standing::class )->create();
    }
}
