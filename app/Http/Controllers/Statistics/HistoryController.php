<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\League;
use App\Standing;
use App\Pick;

class HistoryController extends Controller
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
    	
        return view('statistics.history.index')->with([
        	'leagues'	=> auth()->user()->leagues,
        	'currentLeague'	=> $league,
        	
        	'bestPickems'	=> $this->getBestPickems($league),
        ]);
    }
    
    /**
     * Get best pickems data.
     *
     * @param	\App\League	$league
     *
     * @return	\App\Standing
     */
    public function getBestPickems( League $league )
    {
    	$maxPositionsCorrect	= Standing::byLeague($league)->max('positions_correct');
    	
    	$standingsMaxPosCorrect	= Standing::byLeague($league)->where( 'positions_correct', $maxPositionsCorrect )->get();
    	
    	if( $standingsMaxPosCorrect->count() == 1 )
    		return $standingsMaxPosCorrect->first();
    	
    	return $standingsMaxPosCorrect->sortBy('total')->first();
    }
}
