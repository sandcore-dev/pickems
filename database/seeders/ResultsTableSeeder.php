<?php

namespace Database\Seeders;

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
        Result::factory()
            ->times(200)
            ->create();
    }
}
