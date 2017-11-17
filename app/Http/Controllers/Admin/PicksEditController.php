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

	$leagues	= $season->leagues;
	$league		= $request->league ? League::findOrFail($request->league) : $leagues->first();
	
	$users		= $league->users->getUsersWithPicksByRace($race);
	$user		= $request->user ? User::findOrFail($request->user) : $users->first();
	
	$picks		= $user->picks()->where( 'race_id', $race->id )->get();
	
	$entriesByTeam	= $race->season->entries()->whereNotIn( 'id', $picks->pluck('entry_id') )->get()->getByTeam();
	
        return view('admin.picks.index')->with([
        	'currentSeries'	=> $series,
        	'series'	=> Series::has('seasons.races.picks')->get(),
        	
        	'currentSeason'	=> $season,
        	'seasons'	=> $series->seasons()->has('races.picks')->get(),
        	
        	'currentRace'	=> $race,
        	'races'		=> $season->races()->has('picks')->get(),
        	
        	'currentLeague'	=> $league,
        	'leagues'	=> $leagues,
        	
        	'currentUser'	=> $user,
        	'users'		=> $users,
        	
        	'entriesByTeam'	=> $entriesByTeam,
        	'picks'		=> $picks->padMissing(),
        ]);
    }

    /**
     * Add pick
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Race $race, Request $request )
    {
    	// disabled for now
    	return redirect()->back();
    }
    
    /**
     * Remove pick.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete( Race $race, Request $request )
    {
    	// disabled for now
    	return redirect()->back();
    }
    
    /**
     * Get the highest available rank for this pick.
     *
     * @param	\App\Race
     *
     * @return	integer
     */
    public function getHighestAvailableRank( Race $race )
    {
    	$ranks = Pick::where( 'race_id', $race->id )->orderBy('rank', 'asc')->pluck('rank');
    	
    	foreach( $ranks as $key => $rank )
    	{
    		if( $key + 1 == $rank )
    			continue;
    		
    		return $rank - 1;
    	}
    	
    	return $ranks->max() + 1;
    }
}
