<?php

use Faker\Generator as Faker;

use App\Pick;

use App\Race;
use App\Entry;
use App\User;

$factory->define(Pick::class, function (Faker $faker) {
	$usersWithLeagues	= User::has('leagues')->get();
	
	do
	{
		$raceId			= Race::all()->random()->id;
		$entryId		= Entry::all()->random()->id;
		$leagueUserId		= $usersWithLeagues->random()->leagues->random()->id;
	}
	while( !Pick::where( 'race_id', $raceId )->where( 'entry_id', $entryId )->where( 'league_user_id', $leagueUserId )->get()->isEmpty() );

	$rank				= Pick::where( 'race_id', $raceId )->where( 'league_user_id', $leagueUserId )->max('rank') + 1;
	
	return [
		'race_id'		=> $raceId,
		'entry_id'		=> $entryId,
		'league_user_id'	=> $leagueUserId,
		'rank'			=> $rank,
		'carry_over'		=> 0,
	];
});
