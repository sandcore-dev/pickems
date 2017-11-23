<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Driver;
use App\Country;

class DriversController extends Controller
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
        return view('admin.drivers.index')->with( 'drivers', Driver::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.drivers.create')->with( 'countries', Country::all() );
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
    		'first_name'	=> [ 'required', 'min:2' ],
    		'last_name'	=> [ 'required', 'min:2', Rule::unique('drivers')->where('first_name', $request->input('first_name'))->where('country_id', $request->input('country_id')) ],
    		'country_id'	=> [ 'required', 'integer', 'exists:countries,id' ],
    		'active'	=> [ 'boolean' ],
    	]);
    	
    	if( $driver = Driver::create( $request->only('first_name', 'last_name', 'active', 'country_id') ) )
		session()->flash( 'status', "The driver '{$driver->fullName}' has been added." );
    	
    	return redirect()->route('admin.drivers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $drivers
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
    	return view('admin.drivers.show')->with( 'driver', $driver );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Driver  $drivers
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
    	return view('admin.drivers.edit')->with([
    		'driver'	=> $driver,
    		'countries'	=> Country::all()
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Driver  $drivers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
    	$request->validate([
    		'first_name'	=> [ 'required', 'min:2' ],
    		'last_name'	=> [ 'required', 'min:2', Rule::unique('drivers')->where('first_name', $request->input('first_name'))->where('country_id', $request->input('country_id'))->ignore($driver->id) ],
    		'country_id'	=> [ 'required', 'integer', 'exists:countries,id' ],
    		'active'	=> [ 'boolean' ],
    	]);
    	
    	if( $driver->update( $request->only('first_name', 'last_name', 'active', 'country_id') ) )
		session()->flash( 'status', "The driver '{$driver->fullName}' has been changed." );
    	
    	return redirect()->route('admin.drivers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Driver  $drivers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
    	try {
    		$driver->delete();
    		
    		session()->flash( 'status', "The driver '{$driver->fullName}' has been deleted." );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', "The driver '{$driver->fullName}' could not be deleted." );
    	}
	    	
    	return redirect()->route('admin.drivers.index');
    }
}
