<?php

use Illuminate\Database\Seeder;

use App\Team;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	factory( Team::class, 11 )->create();
    }
}
