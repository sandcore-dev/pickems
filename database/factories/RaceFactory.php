<?php

use Faker\Generator as Faker;

use App\Race;
use App\Season;
use App\Circuit;

$factory->define(Race::class, function (Faker $faker) {
	$race_day	= strtotime( 'next Sunday', $faker->unixTime() );
	$weekend_start	= strtotime( '-3 days', $race_day );
	
	return [
		'season_id'	=> Season::all()->random()->id,
		'circuit_id'	=> Circuit::all()->random()->id,
		'name'		=> 'Grand Prix of ' . $faker->country,
		'weekend_start'	=> date('Y-m-d H:i:s', $weekend_start),
		'race_day'	=> date('Y-m-d', $race_day),
	];
});
