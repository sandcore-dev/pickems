<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;

use App\Series;
use App\League;

class LeaguesController extends Controller
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
    public function index()
    {
        return view('admin.leagues.index')->with([
        	'leagues'	=> League::paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param	\Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.leagues.create')->with( 'series', Series::all() );
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
    		'name'		=> [ 'required', 'min:2', 'unique:leagues' ],
    		'series'	=> [ 'required', 'array', 'min:1' ],
    		'series.*'	=> [ 'required', 'exists:series,id' ],
    	]);
    	
    	if( $league = League::create( $request->only('name') ) )
    	{
		session()->flash( 'status', "The league '{$league->name}' has been added." );
		
		foreach( $request->input('series') as $series )
		{
			$series = Series::findOrFail($series);
			
			$league->seasons()->attach( $series->latestSeason->id );
		}
		
		$league->save();
	}
    	
    	return redirect()->route( 'leagues.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\League  $league
     * @return \Illuminate\Http\Response
     */
    public function show(League $league)
    {
    	return view('admin.leagues.show')->with( 'league', $league );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\League  $league
     * @return \Illuminate\Http\Response
     */
    public function edit(League $league)
    {
    	return view('admin.leagues.edit')->with( 'league', $league );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\League  $league
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, League $league)
    {
    	$request->validate([
    		'name'	=> [ 'required', 'min:2', 'unique:leagues,name,' . $league->id ],
    	]);
    	
    	if( $league->update( $request->only('name') ) )
		session()->flash( 'status', "The league '{$league->name}' has been changed." );
    	
    	return redirect()->route( 'leagues.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\League  $league
     * @return \Illuminate\Http\Response
     */
    public function destroy(League $league)
    {
    	try {
    		$league->delete();
    		
    		session()->flash( 'status', "The league '{$league->name}' has been deleted." );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', "The league '{$league->name}' could not be deleted." );
    	}
	    	
    	return redirect()->route( 'leagues.index' );
    }
}
