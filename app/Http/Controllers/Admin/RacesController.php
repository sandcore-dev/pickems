<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

use App\Http\Controllers\Controller;

use App\Series;
use App\Season;
use App\Circuit;
use App\Race;

use App\Rules\GreaterThanEqual;

class RacesController extends Controller
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
	}
	elseif( $request->season )
	{
	    	$season	= Season::findOrFail($request->season);
	    	$series = $season->series;
	}
	else
	{
		$series	= Series::has('seasons')->first();
		$season	= $series->seasons()->first();
	}
	
        return view('admin.races.index')->with([
        	'currentSeries'	=> $series,
        	'series'		=> Series::has('seasons')->get(),
        	'currentSeason'	=> $season,
        	'seasons'		=> $series->seasons,
        	'races'			=> Race::with('results')->where( 'season_id', $season->id )->paginate(30),
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
    	$season = Season::findOrFail( $request->season );
    	
    	return view('admin.races.create')->with([
    		'season'	=> $season,
    		'circuits'	=> Circuit::all(),
    	]);
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
    		'season_id'				=> [ 'bail', 'required', 'integer', 'exists:seasons,id' ],
    		'name'					=> [ 'required', 'min:2' ],
    		'circuit_id'			=> [ 'required', 'integer', 'exists:circuits,id' ],
    		'race_day_day'			=> [ 'required', 'numeric', 'between:1,31' ],
    		'race_day_month'		=> [ 'required', 'numeric', 'between:1,12' ],
    		'race_day_year'			=> [ 'required', 'numeric' ],
    		'weekend_start_day'		=> [ 'required', 'numeric', 'between:1,31' ],
    		'weekend_start_month'	=> [ 'required', 'numeric', 'between:1,12' ],
    		'weekend_start_year'	=> [ 'required', 'numeric' ],
    	]);
    	
    	$race_day	= Carbon::createFromDate( $request->input('race_day_year'), $request->input('race_day_month'), $request->input('race_day_day') );
    	$weekend_start	= Carbon::create( $request->input('weekend_start_year'), $request->input('weekend_start_month'), $request->input('weekend_start_day'), $request->input('weekend_start_hour'), $request->input('weekend_start_minute'), 0 );
    	
    	if( $weekend_start->greaterThan($race_day) )
    		return redirect()->back()->withInput()->withErrors([ 'weekend_start' => __('The weekend start cannot be after race day.') ]);
    	
    	if( Race::where( 'season_id', $request->input('season_id') )->where( 'circuit_id', $request->input('circuit_id') )->where( 'race_day', $race_day )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'name' => __('This race already exists.') ]);
    	
    	$data					= $request->only('season_id', 'name', 'circuit_id');
    	
    	$data['race_day']		= $race_day;
    	$data['weekend_start']	= $weekend_start;
    	
    	if( $race = Race::create($data) )
			session()->flash( 'status', __( "The race :name has been added.", [ 'name' => $race->name ] ) );
    	
    	return redirect()->route( 'admin.races.index', [ 'season' => $request->season_id ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function show(Race $race)
    {
    	return view('admin.races.show')->with( 'race', $race );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function edit(Race $race)
    {
    	return view('admin.races.edit')->with([
    		'race'		=> $race,
    		'circuits'	=> Circuit::all(),
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Race $race)
    {
    	$request->validate([
    		'name'			=> [ 'required', 'min:2' ],
    		'circuit_id'		=> [ 'required', 'integer', 'exists:circuits,id' ],
    		'race_day_day'		=> [ 'required', 'numeric', 'between:1,31' ],
    		'race_day_month'	=> [ 'required', 'numeric', 'between:1,12' ],
    		'race_day_year'		=> [ 'required', 'numeric' ],
    		'weekend_start_day'	=> [ 'required', 'numeric', 'between:1,31' ],
    		'weekend_start_month'	=> [ 'required', 'numeric', 'between:1,12' ],
    		'weekend_start_year'	=> [ 'required', 'numeric' ],
    	]);
    	
    	$race_day	= Carbon::createFromDate( $request->input('race_day_year'), $request->input('race_day_month'), $request->input('race_day_day') );
    	$weekend_start	= Carbon::create( $request->input('weekend_start_year'), $request->input('weekend_start_month'), $request->input('weekend_start_day'), $request->input('weekend_start_hour'), $request->input('weekend_start_minute'), 0 );
    	
    	if( $weekend_start->greaterThan($race_day) )
    		return redirect()->back()->withInput()->withErrors([ 'weekend_start' => 'The weekend start cannot be after race day.' ]);
    	
    	if( Race::where( 'season_id', $request->input('season_id') )->where( 'circuit_id', $request->input('circuit_id') )->where( 'race_day', $race_day )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'name' => 'This race already exists.' ]);
    	
    	$data			= $request->only('name', 'circuit_id');
    	
    	$data['race_day']	= $race_day;
    	$data['weekend_start']	= $weekend_start;
    	
    	if( $race->update($data) )
		session()->flash( 'status', __( "The race :name has been changed.", [ 'name' => $race->name ] ) );
    	
    	return redirect()->route( 'admin.races.index', [ 'season' => $race->season->id ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Race  $race
     * @return \Illuminate\Http\Response
     */
    public function destroy(Race $race)
    {
    	try {
    		$race->delete();
    		
    		session()->flash( 'status', __( "The race :name has been deleted.", [ 'name' => $race->name ] ) );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', __( "The race :name could not be deleted.", [ 'name' => $race->name ] ) );
    	}
	    	
    	return redirect()->route( 'admin.races.index', [ 'season' => $race->season->id ] );
    }
}
