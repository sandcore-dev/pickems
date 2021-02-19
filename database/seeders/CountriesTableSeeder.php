<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    public function run(): void
    {
        Country::factory()
            ->count(25)
            ->create();
    }
}
