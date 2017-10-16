<?php

use Illuminate\Database\Seeder;

use App\Circuit;

class CircuitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory( Circuit::class, 22 )->create();
    }
}
