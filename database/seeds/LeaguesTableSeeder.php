<?php

use Illuminate\Database\Seeder;

use App\League;

class LeaguesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory( League::class, 20)->create();
    }
}
