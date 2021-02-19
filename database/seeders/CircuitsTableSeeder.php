<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use App\Models\Circuit;

class CircuitsTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!Country::exists()) {
            Circuit::factory()
                ->count(22)
                ->create();
            return;
        }

        $countries = Country::all();

        Circuit::factory()
            ->count(20)
            ->create([
                'country_id' => function () use ($countries) {
                    return $countries->random();
                }
            ]);
    }
}
