<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Series;
use App\Season;
use App\Race;
use App\Pick;
use App\League;
use App\User;

use App\Rules\NotPickedYet;
use App\Rules\MaxPicksExceeded;

class PicksEditController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( [ 'auth', 'admin' ] );
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param	\Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if( $request->series )
    	{
	    	$series	= Series::has('seasons.races.picks')->findOrFail($request->series);
	    	$season = $series->seasons()->has('races.picks')->first();
	    	$race	= $season->races()->has('picks')->previousOrFirst();
	}
	elseif( $request->season )
	{
	    	$season	= Season::has('races.picks')->findOrFail($request->season);
	    	$series = $season->series;
	    	$race	= $season->races()->has('picks')->previousOrFirst();
	}
	elseif( $request->race )
	{
		$race	= Race::has('picks')->findOrFail($request->race);
		$season	= $race->season;
		$series	= $season->series;
	}
	else
	{
		$series	= Series::has('seasons.races.picks')->first();
		$season	= $series->seasons()->has('races.picks')->first();
		$race	= $season->races()->has('picks')->previousOrFirst();
	}

	$leagues	= $series->leagues;
	$league		= $request->league ? League::findOrFail($request->league) : $leagues->first();
	
	$users		= $league->users;
	$user		= $request->user ? User::findOrFail($request->user) : $users->first();
	
	$picks		= Pick::with([ 'entry.driver.country', 'entry.team', 'race.results' ])->byUser($user)->byRace($race)->get();
	
	$entriesByTeam	= $race->season->entries()->with([ 'driver.country', 'team' ])->whereNotIn( 'id', $picks->pluck('entry_id') )->get()->getByTeam();
	
        return view('admin.picks.index')->with([
        	'currentSeries'	=> $series,
        	'series'	=> Series::has('seasons.races.picks')->get(),
        	
        	'currentSeason'	=> $season,
        	'seasons'	=> $series->seasons()->has('races.picks')->get(),
        	
        	'currentRace'	=> $race,
        	'races'		=> $season->races()->with('circuit.country')->has('picks')->get(),
        	
        	'currentLeague'	=> $league,
        	'leagues'	=> $leagues,
        	
        	'currentUser'	=> $user,
        	'users'		=> $users,
        	
        	'entriesByTeam'	=> $entriesByTeam,
        	'picks'		=> $picks->padMissing( $season->picks_max ),
        ]);
    }

    /**
     * Add pick
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Race $race, User $user, Request $request )
    {
    	$request->validate([
    		'entry'	=> [ 'required', 'integer', 'exists:entries,id', new NotPickedYet( $user, $race ), new MaxPicksExceeded( $user, $race, $race->season->picks_max ) ],
    	]);
    	
    	$pick = Pick::create([
    		'race_id'		=> $race->id,
    		'entry_id'		=> $request->entry,
    		'user_id'		=> $user->id,
    		'rank'			=> $this->getHighestAvailableRank( $user, $race ),
    		'carry_over'		=> 0,
    	]);

    	return redirect()->back();
    }
    
    /**
     * Remove pick.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete( Race $race, User $user, Request $request )
    {
    	$request->validate([
    		'pick'	=> [ 'required', 'integer' ],
    	]);
    	
    	$pick = Pick::findOrFail( $request->pick );
    	
    	if( !$pick->carry_over and $pick->race_id == $race->id and $pick->user_id == $user->id )
    		$pick->delete();
    	
    	return redirect()->back();
    }
    
    /**
     * Carry over pickems for a certain user from and to given races.
     *
     * @param	\App\User 	$user
     * @param	\App\Race	$fromRace
     * @param	\App\Race	$toRace
     *
     * @return	void
     */
    public function carryOver( User $user, Race $fromRace, Race $toRace )
    {
    	if( $fromRace->is ( $toRace ) )
    		return;
    	
    	$picks = Pick::byRaceAndUser( $fromRace, $user )->get();
    	
    	foreach( $picks as $pick )
    	{
    		// Picks can be carried over only once.
    		if( $pick->carry_over )
    			continue;

		$newPick = $pick->replicate();
		
		$newPick->race_id	= $toRace->id;
		$newPick->carry_over	= 1;
		
		$newPick->save();
    	}
    }
    
    /**
     * Get the highest available rank for this pick.
     *
     * @param	\App\User
     * @param	\App\Race
     *
     * @return	integer
     */
    public function getHighestAvailableRank( User $user, Race $race )
    {
    	$ranks = Pick::byRaceAndUser( $race, $user )->orderBy('rank', 'asc')->pluck('rank');
    	
    	foreach( $ranks as $key => $rank )
    	{
    		if( $key + 1 == $rank )
    			continue;
    		
    		return $rank - 1;
    	}
    	
    	return $ranks->max() + 1;
    }
}
