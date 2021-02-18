<?php

namespace Database\Seeders;

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
        Team::factory()
            ->times(11)
            ->create();
    }
}
