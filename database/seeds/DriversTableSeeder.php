<?php

use Illuminate\Database\Seeder;

use App\Driver;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory( Driver::class, 25 )->create();
    }
}
