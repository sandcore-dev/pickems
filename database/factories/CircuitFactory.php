<?php

use Faker\Generator as Faker;

use App\Circuit;
use App\Country;

$factory->define(Circuit::class, function (Faker $faker) {
    return [
    	'name'		=> $faker->unique()->city . ' Circuit',
    	'length'	=> $faker->numberBetween( 3000, 25000 ),
    	'city'		=> $faker->city,
    	'country_id'	=> Country::all()->random()->id,
    ];
});
