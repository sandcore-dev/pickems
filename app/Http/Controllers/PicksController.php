<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $leagueId = null, $seasonId = null, $raceId = null )
    {
    	$user		= auth()->user();

    	$leagues	= $user->leagues();
    	
    	if( !$leagueId and $leagues->count() > 0 )
    		return redirect()->route( 'picks', [ 'leagueId' => $leagues->first()->id ] );
    	
    	$currentLeague	= $user->leagues()->findOrFail( $leagueId );
    	
    	$seasons	= $currentLeague->seasons();
    	
    	if( !$seasonId and $seasons->count() > 1 )
    		return redirect()->route( 'picks', [ 'leagueId' => $leagues->first()->id, 'seasonId' => $seasons->first()->id ] );
    	
    	$currentSeason	= $currentLeague->seasons()->findOrFail( $seasonId );

    	$races		= $currentSeason->races();
    	
    	if( !$raceId and $races->count() > 1 )
    		return redirect()->route( 'picks', [ 'leagueId' => $leagues->first()->id, 'seasonId' => $seasons->first()->id, 'raceId' => $races->first()->id ] );
    		
    	$currentRace	= $currentSeason->races()->findOrFail( $raceId );
    	
        return view('picks')->with([
        	'leagues'	=> $leagues->get(),
        	'currentLeague'	=> $currentLeague,
        	
        	'seasons'	=> $seasons->get(),
        	'currentSeason'	=> $currentSeason,
        	
        	'races'		=> $races->get(),
        	'currentRace'	=> $currentRace,
        ]);
    }
}
