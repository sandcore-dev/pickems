<?php

namespace Database\Seeders;

use App\Models\Pick;
use Illuminate\Database\Seeder;

class PicksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pick::factory()
            ->times(500)
            ->create();
    }
}
