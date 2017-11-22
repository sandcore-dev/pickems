<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\League;
use App\Season;
use App\Race;
use App\Standing;

class StandingsListController extends Controller
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
    	
    	$league		= $user->leagues->first();
    	
    	return $this->league( $league );
    }
    
    /**
     * Use league data to go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function league( League $league )
    {
    	$season		= $league->series->seasons()->first();
    	
    	return $this->season( $league, $season );
    }
    
    /**
     * Use season data to go to the default race.
     *
     * @return \Illuminate\Http\Response
     */
    public function season( League $league, Season $season )
    {
    	$race		= $season->races()->previousOrFirst();
    	
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
    		
    	$standings	= $league->standings->where( 'race_id', $race->id );
    	
        return view('standings.index')->with([
        	'leagues'	=> $user->leagues,
        	
        	'currentLeague'	=> $league,
        	'currentRace'	=> $race,
        	
        	'standings'	=> $standings,
        ]);
    }
}
