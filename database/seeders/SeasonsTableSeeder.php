<?php

namespace Database\Seeders;

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
        Season::factory()
            ->times(25)
            ->create();
    }
}
