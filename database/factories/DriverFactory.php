<?php

use Faker\Generator as Faker;

use App\Driver;
use App\Country;

$factory->define(Driver::class, function (Faker $faker) {
    return [
    	'first_name'	=> $faker->firstName,
    	'last_name'	=> $faker->lastName,
    	'country_id'	=> Country::all()->random()->id,
    	'active'	=> $faker->boolean,
    ];
});
