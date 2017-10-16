<?php

use Faker\Generator as Faker;

use App\League;

$factory->define(League::class, function (Faker $faker) {
    return [
    	'name'	=> $faker->unique()->words( 3, true ),
    ];
});
