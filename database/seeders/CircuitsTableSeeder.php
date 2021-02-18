<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Circuit;

class CircuitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Circuit::factory()
            ->times(22)
            ->create();
    }
}
