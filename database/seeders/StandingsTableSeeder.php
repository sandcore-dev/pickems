<?php

namespace Database\Seeders;

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
        Standing::factory()
            ->times(100)
            ->create();
    }
}
