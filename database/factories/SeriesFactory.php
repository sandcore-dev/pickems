<?php

use Faker\Generator as Faker;

use App\Series;

$factory->define(Series::class, function (Faker $faker) {
    return [
    	'name'	=> $faker->unique()->company . ' Championship',
    ];
});
