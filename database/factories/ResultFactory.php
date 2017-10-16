<?php

use Faker\Generator as Faker;

use App\Result;

use App\Race;
use App\Entry;

$factory->define(Result::class, function (Faker $faker) {
    return [
    	'rank'		=> $faker->numberBetween( 1, 22 ),
    	'race_id'	=> Race::all()->random()->id,
    	'entry_id'	=> Entry::all()->random()->id,
    ];
});
