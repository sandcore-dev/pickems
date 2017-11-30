<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\League;
use App\Standing;
use App\Pick;

class FameController extends Controller
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
    public function index( League $league )
    {
    	if( !$league->id or !auth()->user()->leagues->contains($league) )
    		$league = auth()->user()->leagues->first();
    	
        return view('statistics.fame.index')->with([
        	'leagues'	=> auth()->user()->leagues,
        	'currentLeague'	=> $league,
        	
        	'champions'	=> $this->getChampions($league),
        ]);
    }
    
    /**
     * Get champions.
     *
     * @param	\App\League	$league
     *
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    public function getChampions( League $league )
    {
    	$lastRaces = $this->getLastRaceEachSeason($league);
    	
    	return Standing::byLeague($league)
    		->where( 'rank', 1 )
    		->whereIn( 'race_id', $lastRaces )
    		->get()->mapToGroups(function ($item, $key) {
    			return [ $item->user_id => $item ];
    		});
    }
    
    /**
     * Get the last race of each season of the specified league.
     *
     * @parm	\App\league	$league
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
