<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Country::exists()) {
            Driver::factory()
                ->count(25)
                ->create();
            return;
        }

        $countries = Country::all();

        Driver::factory()
            ->create([
                'country_id' => function () use ($countries) {
                    return $countries->random();
                },
            ]);
    }
}
