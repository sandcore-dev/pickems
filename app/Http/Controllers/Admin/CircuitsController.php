<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Circuit;
use App\Country;

class CircuitsController extends Controller
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
        return view('admin.circuits.index')->with( 'circuits', Circuit::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.circuits.create')->with( 'countries', Country::all() );
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
    		'name'		=> [ 'required', 'min:2', 'unique:circuits,name' ],
    		'length'	=> [ 'required', 'integer', 'min:2' ],
    		'city'		=> [ 'required', 'min:2' ],
    		'area'		=> [ 'nullable' ],
    		'country_id'	=> [ 'required', 'integer', 'exists:countries,id' ],
    	]);
    	
    	if( $circuit = Circuit::create( $request->only('name', 'length', 'city', 'area', 'country_id') ) )
		session()->flash( 'status', "The circuit '{$circuit->name}' has been added." );
    	
    	return redirect()->route('circuits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Circuit  $circuits
     * @return \Illuminate\Http\Response
     */
    public function show(Circuit $circuit)
    {
    	return view('admin.circuits.show')->with( 'circuit', $circuit );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Circuit  $circuits
     * @return \Illuminate\Http\Response
     */
    public function edit(Circuit $circuit)
    {
    	return view('admin.circuits.edit')->with([
    		'circuit'	=> $circuit,
    		'countries'	=> Country::all()
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Circuit  $circuits
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circuit $circuit)
    {
    	$request->validate([
    		'name'		=> [ 'required', 'min:2', 'unique:circuits,name,' . $circuit->id ],
    		'length'	=> [ 'required', 'integer', 'min:2' ],
    		'city'		=> [ 'required', 'min:2' ],
    		'area'		=> [ 'nullable' ],
    		'country_id'	=> [ 'required', 'integer', 'exists:countries,id' ],
    	]);
    	
    	if( $circuit->update( $request->only('name', 'length', 'city', 'area', 'country_id') ) )
		session()->flash( 'status', "The circuit '{$circuit->name}' has been changed." );
    	
    	return redirect()->route('circuits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Circuit  $circuits
     * @return \Illuminate\Http\Response
     */
    public function destroy(Circuit $circuit)
    {
    	try {
    		$circuit->delete();
    		
    		session()->flash( 'status', "The circuit '{$circuit->name}' has been deleted." );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', "The circuit '{$circuit->name}' could not be deleted." );
    	}
	    	
    	return redirect()->route('circuits.index');
    }
}
