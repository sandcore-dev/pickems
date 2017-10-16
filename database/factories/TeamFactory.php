<?php

use Faker\Generator as Faker;

use App\Team;
use App\Country;

$factory->define(Team::class, function (Faker $faker) {
    return [
    	'name'		=> $faker->unique()->company . ' Team',
    	'country_id'	=> Country::all()->random()->id,
    	'active'	=> $faker->boolean,
    ];
});
