<?php

use Faker\Generator as Faker;

use App\Season;
use App\Series;

$factory->define(Season::class, function (Faker $faker) {
	$start_year	= $faker->year();
	$end_year	= $faker->boolean ? $start_year : $start_year + 1;
	
	return [
		'series_id'	=> Series::all()->random()->id,
		'start_year'	=> $start_year,
		'end_year'	=> $end_year,
	];
});
