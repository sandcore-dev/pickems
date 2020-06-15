<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Circuit;
use App\Country;
use Illuminate\View\View;

class CircuitsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([ 'auth', 'admin' ]);
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('admin.circuits.index')->with('circuits', Circuit::with([ 'races', 'country' ])->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.circuits.create')->with('countries', Country::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $request->validate(
            [
            'name'      => [ 'required', 'min:2', 'unique:circuits,name' ],
            'length'    => [ 'required', 'integer', 'min:2' ],
            'city'      => [ 'required', 'min:2' ],
            'area'      => [ 'nullable' ],
            'country_id'    => [ 'required', 'integer', 'exists:countries,id' ],
            ]
        );
        
        if ($circuit = Circuit::create($request->only('name', 'length', 'city', 'area', 'country_id'))) {
            session()->flash('status', __("The circuit :name has been added.", [ 'name' => $circuit->name ]));
        }
        
        return redirect()->route('admin.circuits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Circuit $circuit
     * @return Factory|Application|View
     */
    public function show(Circuit $circuit)
    {
        return view('admin.circuits.show')->with('circuit', $circuit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Circuit $circuit
     * @return Factory|Application|View
     */
    public function edit(Circuit $circuit)
    {
        return view('admin.circuits.edit')->with(
            [
            'circuit'   => $circuit,
            'countries' => Country::all()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Circuit $circuit
     * @return RedirectResponse
     */
    public function update(Request $request, Circuit $circuit)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $request->validate(
            [
            'name'      => [ 'required', 'min:2', 'unique:circuits,name,' . $circuit->id ],
            'length'    => [ 'required', 'integer', 'min:2' ],
            'city'      => [ 'required', 'min:2' ],
            'area'      => [ 'nullable' ],
            'country_id'    => [ 'required', 'integer', 'exists:countries,id' ],
            ]
        );
        
        if ($circuit->update($request->only('name', 'length', 'city', 'area', 'country_id'))) {
            session()->flash('status', __("The circuit :name has been changed.", [ 'name' => $circuit->name ]));
        }
        
        return redirect()->route('admin.circuits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Circuit $circuit
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Circuit $circuit)
    {
        try {
            $circuit->delete();
            
            session()->flash('status', __("The circuit :name has been deleted.", [ 'name' => $circuit->name ]));
        } catch (QueryException $e) {
            session()->flash('status', __("The circuit :name could not be deleted.", [ 'name' => $circuit->name ]));
        }
            
        return redirect()->route('admin.circuits.index');
    }
}
