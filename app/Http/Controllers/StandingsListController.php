<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\UserSeasonsList;

use App\League;
use App\Season;
use App\Race;
use App\Standing;

class StandingsListController extends Controller
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
    	$race		= $season->races()->previousOrFirst();
    	
    	if( !$race->count() )
			return view('picks.error')->with( 'error', __("There are no races available.") );

    	return redirect()->route( 'standings.race', [ 'league' => $league->id, 'race' => $race->id ] );
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
    	
    	$league->load( 'standings.user' );
    	
    	$standings	= $league->standings->where( 'race_id', $race->id );
    	
        return view('standings.index')->with([
        	'leagues'	=> $user->leagues,
        	
        	'currentLeague'	=> $league,
        	'currentRace'	=> $race,
        	
        	'standings'	=> $standings,
        ]);
    }
}
