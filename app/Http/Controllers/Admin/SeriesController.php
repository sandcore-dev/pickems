<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;

use App\Series;

class SeriesController extends Controller
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
        return view('admin.series.index')->with( 'series', Series::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('admin.series.create');
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
    		'name'	=> [ 'required', 'min:2', 'unique:series,name' ],
    	]);
    	
    	if( $series = Series::create( $request->only('name') ) )
		session()->flash( 'status', "The series '{$series->name}' has been added." );
    	
    	return redirect()->route('series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
    	return view('admin.series.show')->with( 'series', $series );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function edit(Series $series)
    {
    	return view('admin.series.edit')->with( 'series', $series );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series $series)
    {
    	$request->validate([
    		'name'	=> [ 'required', 'min:2', Rule::unique('series')->ignore($series->id) ],
    	]);
    	
    	if( $series->update( $request->only('name') ) )
		session()->flash( 'status', "The series '{$series->name}' has been changed." );
    	
    	return redirect()->route('series.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series $series)
    {
    	try {
    		$series->delete();
    		
    		session()->flash( 'status', "The series '{$series->name}' has been deleted." );
    	} catch( QueryException $e ) {
    		session()->flash( 'status', "The series '{$series->name}' could not be deleted." );
    	}
	    	
    	return redirect()->route('series.index');
    }
}
