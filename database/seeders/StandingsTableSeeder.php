<?php

namespace Database\Seeders;

use App\Models\Standing;
use Illuminate\Database\Seeder;

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
