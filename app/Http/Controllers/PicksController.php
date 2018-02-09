<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Traits\UserSeasonsList;

use App\User;
use App\League;
use App\Season;
use App\Race;
use App\Pick;

use App\Rules\NotPickedYet;
use App\Rules\MaxPicksExceeded;

class PicksController extends Controller
{
	use UserSeasonsList;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Use season data to go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function season( League $league, Season $season )
    {
    	$race = $season->races()->nextOrLast();
    	
    	if( !$race->count() )
			return view('picks.error')->with( 'error', "There are no races available." );

    	return redirect()->route( 'picks.race', [ 'league' => $league->id, 'race' => $race->id ] );
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function race( League $league, Race $race )
    {
    	$user		= auth()->user();
    	
    	if( !$user->leagues->contains($league) )
    		abort(404);
    	
    	$picks		= Pick::with([ 'entry.driver.country', 'entry.team', 'race.results' ])->byUser($user)->byRace($race)->get();
    	
    	$entriesByTeam	= $race->season->entries()->with([ 'driver.country', 'team' ])->whereNotIn( 'id', $picks->pluck('entry_id') )->get()->getByTeam();
    		
        return view('picks.index')->with([
        	'leagues'		=> $user->leagues,
        	'seasons'		=> $this->getSeasons( $league ),
        	
        	'currentLeague'	=> $league,
        	'currentRace'	=> $race->load('season.races.circuit.country'),
        	
        	'entriesByTeam'	=> $entriesByTeam,
        	'picks'			=> $picks->padMissing( $race->season->picks_max ),
        ]);
    }

    /**
     * Add pick.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( League $league, Race $race, Request $request )
    {
    	$user		= auth()->user();
    	
    	if( !$user->leagues->contains($league) )
    		abort(404);
    	
    	if( !$league->series->seasons->contains($race->season) )
    		abort(404);
    	
    	if( $race->weekend_start->lte( Carbon::now() ) )
    		abort(404);
    	
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
    public function delete( League $league, Race $race, Request $request )
    {
    	$user		= auth()->user();
    	
    	if( !$user->leagues->contains($league) )
    		abort(404);
    	
    	if( !$league->series->seasons->contains($race->season) )
    		abort(404);
    	
    	if( $race->weekend_start->lte( Carbon::now() ) )
    		return redirect()->back();
    	
    	$request->validate([
    		'pick'	=> [ 'required', 'integer' ],
    	]);
    	
    	$pick = Pick::findOrFail( $request->pick );
    	
    	if( $pick->race_id == $race->id and $pick->user_id == $user->id )
    		$pick->delete();
    	
    	return redirect()->back();
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
