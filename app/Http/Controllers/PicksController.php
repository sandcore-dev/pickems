<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\League;
use App\Season;
use App\Race;
use App\Pick;

use App\Pivots\PickUser;

use App\Rules\NotPickedYet;
use App\Rules\MaxPicksExceeded;

class PicksController extends Controller
{
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
    	
    	$league		= $user->leagues()->first();
    	
    	return $this->league( $league );
    }
    
    /**
     * Use league data to go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function league( League $league )
    {
    	$season		= $league->seasons()->first();
    	
    	return $this->season( $league, $season );
    }
    
    /**
     * Use season data to go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function season( League $league, Season $season )
    {
    	$race		= $season->races()->nextOrLast();
    	
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
    	
    	$picks		= auth()->user()->picks->getByRace($race);
    	
    	$entriesByTeam	= $race->season->entries()->whereNotIn( 'id', $picks->pluck('entry_id') )->get()->getByTeam();
    		
        return view('picks.index')->with([
        	'leagues'	=> $user->leagues,
        	
        	'currentLeague'	=> $league,
        	'currentRace'	=> $race,
        	
        	'entriesByTeam'	=> $entriesByTeam,
        	'picks'		=> $picks->padMissing(),
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
    	
    	if( !$league->seasons->contains($race->season) )
    		abort(404);
    	
    	if( $race->weekend_start->lte( Carbon::now() ) )
    		abort(404);
    	
    	$userLeague = $user->leagues()->where( 'leagues.id', $league->id )->first();
    	
    	$request->validate([
    		'entry'	=> [ 'required', 'integer', 'exists:entries,id', new NotPickedYet( $userLeague->pivot, $race ), new MaxPicksExceeded( $userLeague->pivot, $race, config('picks.max') ) ],
    	]);
    	
    	$pick = Pick::create([
    		'race_id'		=> $race->id,
    		'entry_id'		=> $request->entry,
    		'league_user_id'	=> $userLeague->pivot->id,
    		'rank'			=> $this->getHighestAvailableRank( $userLeague->pivot, $race ),
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
    	
    	if( !$league->seasons->contains($race->season) )
    		abort(404);
    	
    	if( $race->weekend_start->lte( Carbon::now() ) )
    		return redirect()->back();
    	
    	$userLeague = $user->leagues()->where( 'leagues.id', $league->id )->first();
    	
    	$request->validate([
    		'pick'	=> [ 'required', 'integer' ],
    	]);
    	
    	$pick = Pick::findOrFail( $request->pick );
    	
    	if( $pick->race_id == $race->id and $pick->league_user_id == $userLeague->pivot->id )
    		$pick->delete();
    	
    	return redirect()->back();
    }
    
    /**
     * Get the highest available rank for this pick.
     *
     * @param	\App\Pivots\PickUser
     * @param	\App\Race
     *
     * @return	integer
     */
    public function getHighestAvailableRank( PickUser $pivot, Race $race )
    {
    	$ranks = Pick::where( 'race_id', $race->id )->where( 'league_user_id', $pivot->id )->orderBy('rank', 'asc')->pluck('rank');
    	
    	foreach( $ranks as $key => $rank )
    	{
    		if( $key + 1 == $rank )
    			continue;
    		
    		return $rank - 1;
    	}
    	
    	return $ranks->max() + 1;
    }
}
