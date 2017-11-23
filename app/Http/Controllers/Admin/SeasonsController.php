<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Series;
use App\Season;

use App\Rules\GreaterThanEqual;

class SeasonsController extends Controller
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
    	$series = $request->series ? Series::findOrFail($request->series) : Series::first();
    	
        return view('admin.seasons.index')->with([
        	'currentSeries'	=> $series,
        	'series'	=> Series::all(),
        	'seasons'	=> Season::where( 'series_id', $series->id )->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param	\Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$series = Series::findOrFail( $request->series );
    	
    	return view('admin.seasons.create')->with( 'series', $series );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'series_id'	=> [ 'bail', 'required', 'exists:series,id' ],
    		'start_year'	=> [ 'required', 'integer', 'between:1970,9999' ],
    		'end_year'	=> [ 'required', 'integer', 'between:1970,9999', 'gte:start_year' ],
    	]);
    	
    	if( Season::where( 'series_id', $request->input('series_id') )->where( 'start_year', $request->input('start_year') )->where( 'end_year', $request->input('end_year') )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'start_year' => 'This season already exists.' ]);
    	
    	if( $season = Season::create( $request->only('series_id', 'start_year', 'end_year') ) )
    	{
		session()->flash( 'status', "The season '{$season->name}' has been added." );
		
		foreach( $season->previous->leagues as $league )
			$league->seasons()->attach( $season->id );
	}
    	
    	return redirect()->route( 'admin.seasons.index', [ 'series' => $request->series_id ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season)
    {
    	return view('admin.seasons.show')->with( 'season', $season );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(Season $season)
    {
    	return view('admin.seasons.edit')->with( 'season', $season );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Season $season)
    {
    	$request->validate([
    		'start_year'	=> [ 'required', 'integer', 'between:1970,9999' ],
    		'end_year'	=> [ 'required', 'integer', 'between:1970,9999', 'gte:start_year' ],
    	]);
    	
    	if( Season::where( 'series_id', $season->series->id )->where( 'start_year', $request->input('start_year') )->where( 'end_year', $request->input('end_year') )->where( 'id', '!=', $season->id )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'start_year' => 'This season already exists.' ]);
    	
    	if( $season->update( $request->only('start_year', 'end_year') ) )
		session()->flash( 'status', "The season '{$season->name}' has been changed." );
    	
    	return redirect()->route( 'admin.seasons.index', [ 'series' => $season->series->id ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season)
    {
    	try {
    		$season->delete();
    		
    		session()->flash( 'status', "The season '{$season->name}' has been deleted." );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', "The season '{$season->name}' could not be deleted." );
    	}
	    	
    	return redirect()->route( 'admin.seasons.index', [ 'series' => $season->series->id ] );
    }
}
