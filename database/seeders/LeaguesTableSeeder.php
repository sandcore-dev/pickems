<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\League;

class LeaguesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        League::factory()
            ->times(20)
            ->create();
    }
}
