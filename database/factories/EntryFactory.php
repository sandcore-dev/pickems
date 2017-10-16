<?php

use Faker\Generator as Faker;

use App\Entry;

use App\Season;
use App\Team;
use App\Driver;

$factory->define(Entry::class, function (Faker $faker) {
	do
	{
		$seasonId 	= Season::all()->random()->id;
		$teamId		= Team::all()->random()->id;
		$driverId	= Driver::all()->random()->id;
	}
	while( !Entry::where( 'season_id', $seasonId )->where( 'team_id', $teamId )->where( 'driver_id', $driverId )->get()->isEmpty() );

	return [
		'season_id'	=> $seasonId,
		'team_id'	=> $teamId,
		'driver_id'	=> $driverId,
		'car_number'	=> $faker->unique()->numberBetween(0, 99),
		'active'	=> $faker->boolean,
	];
});
