<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\League;
use App\Standing;
use App\Pick;

class AllTimeController extends Controller
{
    /**
     * Minimum number of seasons to be listed in the all-time rankings.
     *
     * @var	integer
     */
    protected $minSeasons = 5;
    
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
    public function index( League $league )
    {
    	if( !$league->id or !auth()->user()->leagues->contains($league) )
    		$league = auth()->user()->leagues->first();
    	
        return view('statistics.alltime.index')->with([
        	'leagues'	=> auth()->user()->leagues,
        	'currentLeague'	=> $league,
        	
        	'averages'	=> $this->getAverages($league),
        ]);
    }
    
    /**
     * Get end-of-season data for each user.
     *
     * @param	\App\League	$league
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function getAverages( League $league )
    {
    	$lastRaces		= $this->getLastRaceEachSeason($league);
    	
    	$finalStandings		= Standing::with('user')->byLeague($league)->whereIn( 'race_id', $lastRaces )->get();
    	
    	$mappedByUser		= $finalStandings->mapToGroups(function ($item, $key) {
    		return [ $item->user_id => $item ];
    	});
    	
    	$minSeasons		= $mappedByUser->reject(function ($value, $key) {
    		return $value->count() < $this->minSeasons;
    	});
    	
    	$sortedByAverages	= $minSeasons->sort(function ($a, $b) {
    		return $a->avg('rank') <=> $b->avg('rank');
    	});
    	
   	return $sortedByAverages;
    }
    
    /**
     * Get the last race of each season of the specified league.
     *
     * @parm	\App\League	$league
     *
     * @return	array
     */
    protected function getLastRaceEachSeason( League $league )
    {
    	$out = [];
    	
    	foreach( $league->series->seasons as $season )
    		$out[] = $season->races->last()->id;
    	
    	return $out;
    }
}
