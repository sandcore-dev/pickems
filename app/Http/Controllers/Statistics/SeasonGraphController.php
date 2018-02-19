<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Traits\UserSeasonsList;

use App\League;
use App\Season;
use App\Standing;
use App\User;

class SeasonGraphController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( League $league, Season $season, User $user )
    {
    	if( !$league->id or !auth()->user()->leagues->contains($league) )
    		$league = auth()->user()->leagues->first();
    	
    	if( !$user->id or !$league->users->contains($user) )
	    	$user = auth()->user();
	    	
	    $seasons = $this->getSeasons( $league, $user, false );
	    
    	if( $seasons->isEmpty() )
			return view('picks.error')->with( 'error', __("There are no seasons available.") );

    	if( !$season->id or !$league->series->seasons->contains($season) )
    		$season = $seasons->first();
	    	
        return view('statistics.season.index')->with([
        	'leagues'		=> auth()->user()->leagues,
        	'seasons'		=> $seasons,
        	'users'			=> Standing::with('user')->whereIn( 'race_id', $season->races->pluck('id') )->get()->users(),
        	'currentLeague'	=> $league,
        	'currentSeason'	=> $season,
        	'currentUser'	=> $user,
        	'chartData'		=> Standing::with(['league.users', 'race.circuit.country'])->byLeague($league)->bySeason($season)->byUser($user)->get()->getChartData(),
        ]);
    }
}
