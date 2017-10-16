<?php

use Illuminate\Database\Seeder;

use App\Result;

class ResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory( Result::class, 200 )->create();
    }
}
