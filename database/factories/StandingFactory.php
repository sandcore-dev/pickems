<?php

use Faker\Generator as Faker;

use App\Standing;

use App\User;
use App\Race;

$factory->define(Standing::class, function (Faker $faker) {
	$usersWithLeagues	= User::has('leagues')->get();
	
	do
	{
		$leagueUserId	= $usersWithLeagues->random()->leagues->random()->id;
		$raceId		= Race::all()->random()->id;
	}
	while( !Standing::where( 'league_user_id', $leagueUserId )->where( 'race_id', $raceId )->get()->isEmpty() );

	return [
		'league_user_id'	=> $leagueUserId,
		'race_id'		=> $raceId,
		'rank'			=> $faker->numberBetween( 1, User::count() ),
		'previous_id'		=> null,
		'picked'		=> $faker->randomNumber( 3 ),
		'positions_correct'	=> $faker->randomNumber( 2 ),
	];
});
