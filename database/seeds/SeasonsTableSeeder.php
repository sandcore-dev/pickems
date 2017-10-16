<?php

use Illuminate\Database\Seeder;

use App\Season;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory( Season::class, 25 )->create();
    }
}
