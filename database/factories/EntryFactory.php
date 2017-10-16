<?php

use Faker\Generator as Faker;

use App\Entry;
use App\Season;
use App\Team;
use App\Driver;

$factory->define(Entry::class, function (Faker $faker) {
    return [
    	'season_id'	=> Season::all()->random()->id,
    	'team_id'	=> Team::all()->random()->id,
    	'driver_id'	=> Driver::all()->random()->id,
    	'car_number'	=> $faker->unique()->numberBetween(0, 99),
    	'active'	=> $faker->boolean,
    ];
});
