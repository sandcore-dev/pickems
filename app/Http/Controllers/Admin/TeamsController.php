<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Team;
use App\Country;

class TeamsController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.teams.index')->with( 'teams', Team::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.teams.create')->with( 'countries', Country::all() );
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
    		'name'		=> [ 'required', 'min:2', 'unique:teams' ],
    		'country_id'	=> [ 'required', 'integer', 'exists:countries,id' ],
    		'active'	=> [ 'boolean' ],
    	]);
    	
    	if( $team = Team::create( $request->only('name', 'active', 'country_id') ) )
		session()->flash( 'status', "The team '{$team->name}' has been added." );
    	
    	return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $teams
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
    	return view('admin.teams.show')->with( 'team', $team );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $teams
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
    	return view('admin.teams.edit')->with([
    		'team'		=> $team,
    		'countries'	=> Country::all()
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $teams
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
    	$request->validate([
    		'name'		=> [ 'required', 'min:2', 'unique:teams,name,' . $team->id ],
    		'country_id'	=> [ 'required', 'integer', 'exists:countries,id' ],
    		'active'	=> [ 'boolean' ],
    	]);
    	
    	if( $team->update( $request->only('name', 'active', 'country_id') ) )
		session()->flash( 'status', "The team '{$team->name}' has been changed." );
    	
    	return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $teams
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
    	try {
    		$team->delete();
    		
    		session()->flash( 'status', "The team '{$team->name}' has been deleted." );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', "The team '{$team->name}' could not be deleted." );
    	}
	    	
    	return redirect()->route('teams.index');
    }
}
