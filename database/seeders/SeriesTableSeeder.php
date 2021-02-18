<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Series;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Series::factory()
            ->times(10)
            ->create();
    }
}
