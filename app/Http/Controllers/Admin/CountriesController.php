<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Country;

class CountriesController extends Controller
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
        return view('admin.countries.index')->with( 'countries', Country::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.countries.create');
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
    		'code'	=> [ 'required', 'alpha', 'size:2', 'unique:countries' ],
    		'name'	=> [ 'required', 'min:2', 'unique:countries' ],
    	]);
    	
    	if( $country = Country::create( $request->only('code', 'name') ) )
		session()->flash( 'status', __( "The country :name has been added.", [ 'name' => $country->name ] ) );
    	
    	return redirect()->route('admin.countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
    	return view('admin.countries.show')->with( 'country', $country );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
    	return view('admin.countries.edit')->with( 'country', $country );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
    	$request->validate([
    		'code'	=> [ 'required', 'alpha', 'size:2', 'unique:countries,code,' . $country->id ],
    		'name'	=> [ 'required', 'min:2', 'unique:countries,name,' . $country->id ],
    	]);
    	
    	if( $country->update( $request->only('code', 'name') ) )
		session()->flash( 'status', __( "The country :name has been changed.", [ 'name' => $country->name ] ) );
    	
    	return redirect()->route('admin.countries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
    	try {
    		$country->delete();
    		
    		session()->flash( 'status', __( "The country :name has been deleted.", [ 'name' => $country->name ] ) );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', __( "The country :name could not be deleted.", [ 'name' => $country->name ] ) );
    	}
	    	
    	return redirect()->route('admin.countries.index');
    }
}
