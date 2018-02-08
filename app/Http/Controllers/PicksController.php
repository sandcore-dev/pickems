<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\User;
use App\League;
use App\Season;
use App\Race;
use App\Pick;

use App\Rules\NotPickedYet;
use App\Rules\MaxPicksExceeded;

class PicksController extends Controller
{
	/**
	 * Cache the result of getSeasons.
	 * 
	 * @var array of \Illuminate\Support\Collection
	 */
	protected $seasons;
	
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
     * Go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$user		= auth()->user();
    	
    	$league		= $user->leagues->first();
    	
    	if( !$league )
			return view('picks.error')->with( 'error', "You haven't joined any leagues." );
    	
    	return $this->league( $league );
    }
    
    /**
     * Use league data to go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function league( League $league )
    {
    	# $season		= $league->series->seasons->first();
    	$season		= $this->getSeasons( $league )->first();
    	
    	if( !$season )
			return view('picks.error')->with( 'error', "There are no seasons available." );

    	return $this->season( $league, $season );
    }
    
    /**
     * Get seasons for the current user and given league.
     * Those should be only future ones or the ones the user participated in.
     * 
     * @param	\App\League	$league
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    protected function getSeasons( League $league )
    {
		if( $this->seasons[ $league->id ] )
			return $this->seasons[ $league->id ];
		
		$seasons	= [];
		$user		= auth()->user();
		
		foreach( $league->series->seasons as $season )
		{
			if( $season->end_year < date('Y') )
			{
				if( Pick::byUser( $user )->whereIn( 'race_id', $season->races->pluck('id') )->count() )
					$seasons[ $season->id ] = $season;
			}
			else
			{
				$seasons[] = $season;
			}
		}
		
		$this->seasons[ $league->id ] = collect($seasons);
		
		return $this->seasons[ $league->id ];
    }
    
    /**
     * Use season data to go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function season( League $league, Season $season )
    {
    	$race		= $season->races()->nextOrLast();
    	
    	if( !$race )
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
