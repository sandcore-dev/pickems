<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\League;
use App\Season;
use App\Standing;
use App\User;

class SeasonGraphController extends Controller
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
    public function index( League $league, Season $season, User $user )
    {
    	if( !$league->id or !auth()->user()->leagues->contains($league) )
    		$league = auth()->user()->leagues->first();
    	
    	if( !$season->id or !$league->series->seasons->contains($season) )
    		$season = $league->series->seasons->first();
    	
    	if( !$user->id or !$league->users->contains($user) )
	    	$user = auth()->user();
	    	
        return view('statistics.season.index')->with([
        	'leagues'	=> auth()->user()->leagues,
        	'users'		=> Standing::with('user')->whereIn( 'race_id', $season->races->pluck('id') )->get()->users(),
        	'currentLeague'	=> $league,
        	'currentSeason'	=> $season,
        	'currentUser'	=> $user,
        ]);
    }
}
