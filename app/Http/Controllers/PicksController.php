<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\League;
use App\Season;
use App\Race;

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
    		
        return view('picks.index')->with([
        	'leagues'	=> $user->leagues,
        	'currentLeague'	=> $league,
        	'currentRace'	=> $race,
        ]);
    }

    /**
     * Add pick.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( League $league, Race $race )
    {
    	$user		= auth()->user();
    	
    	if( !$user->leagues->contains($league) )
    		abort(404);
    	
    	dd( $user->leagues()->whereIn( 'leagues.id', $league )->first()->pivot );
    }
}
