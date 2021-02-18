<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeagueUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leagues = League::all();
        $users = User::all();

        for ($i = 0; $i < 50; $i++) {
            $leagues->random()->users()->syncWithoutDetaching($users->random()->id);
        }
    }
}
