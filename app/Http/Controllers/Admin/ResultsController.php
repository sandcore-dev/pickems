<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Series;
use App\Season;
use App\Race;
use App\Result;

use App\Rules\NotPickedYet;
use App\Rules\MaxPicksExceeded;

class ResultsController extends Controller
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
	    	$series	= Series::has('seasons')->findOrFail($request->series);
	    	$season = $series->seasons()->first();
	    	$race	= $season->races()->previousOrFirst();
	}
	elseif( $request->season )
	{
	    	$season	= Season::findOrFail($request->season);
	    	$series = $season->series;
	    	$race	= $season->races()->previousOrFirst();
	}
	elseif( $request->race )
	{
		$race	= Race::findOrFail($request->race);
		$season	= $race->season;
		$series	= $season->series;
	}
	else
	{
		$series	= Series::has('seasons')->first();
		$season	= $series->seasons()->first();
		$race	= $season->races()->previousOrFirst();
	}
	
	$results	= Result::where( 'race_id', $race->id )->get();
	$entriesByTeam	= $race->season->entries()->whereNotIn( 'id', $results->pluck('entry_id') )->get()->getByTeam();
	
        return view('admin.results.index')->with([
        	'currentSeries'	=> $series,
        	'series'	=> Series::has('seasons')->get(),
        	'currentSeason'	=> $season,
        	'seasons'	=> $series->seasons,
        	'currentRace'	=> $race,
        	'races'		=> $season->races,
        	'entriesByTeam'	=> $entriesByTeam,
        	'results'	=> $results->padMissing(),
        	'showRecalcBut'	=> $results->count() >= config('picks.max'),
        ]);
    }

    /**
     * Add result
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Race $race, Request $request )
    {
    	$request->validate([
    		'entry'	=> [ 'required', 'integer', 'exists:entries,id' ],
    	]);
    	
    	$pick = Result::create([
    		'race_id'		=> $race->id,
    		'entry_id'		=> $request->entry,
    		'rank'			=> $this->getHighestAvailableRank( $race ),
    	]);
    	
    	return redirect()->back();
    }
    
    /**
     * Remove pick.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete( Race $race, Request $request )
    {
    	$request->validate([
    		'result'	=> [ 'required', 'integer' ],
    	]);
    	
    	$result = Result::findOrFail( $request->result );
    	
	$result->delete();
    	
    	return redirect()->back();
    }
    
    /**
     * Get the highest available rank for this result.
     *
     * @param	\App\Race
     *
     * @return	integer
     */
    public function getHighestAvailableRank( Race $race )
    {
    	$ranks = Result::where( 'race_id', $race->id )->orderBy('rank', 'asc')->pluck('rank');
    	
    	foreach( $ranks as $key => $rank )
    	{
    		if( $key + 1 == $rank )
    			continue;
    		
    		return $rank - 1;
    	}
    	
    	return $ranks->max() + 1;
    }
}
