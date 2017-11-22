<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

use App\Http\Controllers\Controller;

use App\Series;
use App\Season;
use App\Team;
use App\Driver;
use App\Entry;

use App\Rules\GreaterThanEqual;
use App\Rules\ValidHexValue;

class EntriesController extends Controller
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
	
        return view('admin.entries.index')->with([
        	'currentSeries'	=> $series,
        	'series'	=> Series::has('seasons')->get(),
        	'currentSeason'	=> $season,
        	'seasons'	=> $series->seasons,
        	'entries'	=> Entry::where( 'season_id', $season->id )->paginate(30),
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
    	
    	return view('admin.entries.create')->with([
    		'season'	=> $season,
        	'teams'		=> Team::where( 'active', 1 )->get(),
        	'drivers'	=> Driver::where( 'active', 1 )->get(),
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
    		'season_id'		=> [ 'bail', 'required', 'integer', 'exists:seasons,id' ],
    		'car_number'		=> [ 'required', 'numeric' ],
    		'team_id'		=> [ 'required', 'integer', 'exists:teams,id' ],
    		'driver_id'		=> [ 'required', 'integer', 'exists:drivers,id' ],
    		'abbreviation'		=> [ 'required', 'size:3' ],
    		'color'			=> [ 'required', new ValidHexValue ],
    		'active'		=> [ 'boolean' ],
    	]);
    	
    	if( Entry::where( 'season_id', $request->input('season_id') )->where( 'team_id', $request->input('team_id') )->where( 'driver_id', $request->input('driver_id') )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'car_number' => 'This entry already exists.' ]);
    	
    	if( Entry::where( 'season_id', $request->input('season_id') )->where( 'team_id', $request->input('team_id') )->where( 'abbreviation', $request->input('abbreviation') )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'abbreviation' => 'The abbreviation is already in use for this team.' ]);
    	
    	if( $entry = Entry::create( $request->only('season_id', 'car_number', 'color', 'team_id', 'driver_id', 'abbreviation', 'active') ) )
		session()->flash( 'status', "The entry '{$entry->car_number}' has been added." );
    	
    	return redirect()->route( 'admin.entries.index', [ 'season' => $request->season_id ] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
    	return view('admin.entries.show')->with( 'entry', $entry );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
    	return view('admin.entries.edit')->with([
    		'entry'		=> $entry,
        	'teams'		=> Team::where( 'active', 1 )->get(),
        	'drivers'	=> Driver::where( 'active', 1 )->get(),
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
    	$request->validate([
    		'car_number'		=> [ 'required', 'numeric' ],
    		'team_id'		=> [ 'required', 'integer', 'exists:teams,id' ],
    		'driver_id'		=> [ 'required', 'integer', 'exists:drivers,id' ],
    		'color'			=> [ 'required', new ValidHexValue ],
    		'abbreviation'		=> [ 'required', 'size:3' ],
    		'active'		=> [ 'boolean' ],
    	]);
    	
    	if( Entry::where( 'season_id', $request->input('season_id') )->where( 'team_id', $request->input('team_id') )->where( 'driver_id', $request->input('driver_id') )->where( 'id', '!=', $entry->id )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'car_number' => 'This entry already exists.' ]);
    	
    	if( Entry::where( 'season_id', $request->input('season_id') )->where( 'team_id', $request->input('team_id') )->where( 'abbreviation', $request->input('abbreviation') )->where( 'id', '!=', $entry->id )->count() )
    		return redirect()->back()->withInput()->withErrors([ 'abbreviation' => 'The abbreviation is already in use for this team.' ]);
    	
    	if( $entry->update( $request->only('season_id', 'car_number', 'abbreviation', 'color', 'team_id', 'driver_id', 'active') ) )
		session()->flash( 'status', "The entry '{$entry->car_number}' has been changed." );
    	
    	return redirect()->route( 'admin.entries.index', [ 'season' => $entry->season->id ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
    	try {
    		$entry->delete();
    		
    		session()->flash( 'status', "The entry '{$entry->car_number}' has been deleted." );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', "The entry '{$entry->car_number}' could not be deleted." );
    	}
	    	
    	return redirect()->route( 'admin.entries.index', [ 'season' => $entry->season->id ] );
    }
}
