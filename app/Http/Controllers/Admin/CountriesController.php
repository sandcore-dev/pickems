<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\View\View;

class CountriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('admin.countries.index')->with('countries', Country::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'code' => ['required', 'alpha', 'size:2', 'unique:countries'],
                'name' => ['required', 'min:2', 'unique:countries'],
            ]
        );

        if ($country = Country::create($request->only('code', 'name'))) {
            session()->flash('status', __("The country :name has been added.", ['name' => $country->name]));
        }

        return redirect()->route('admin.countries.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return Factory|Application|View
     */
    public function show(Country $country)
    {
        return view('admin.countries.show')->with('country', $country);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Country $country
     * @return Factory|Application|View
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function update(Request $request, Country $country)
    {
        $request->validate(
            [
                'code' => ['required', 'alpha', 'size:2', 'unique:countries,code,' . $country->id],
                'name' => ['required', 'min:2', 'unique:countries,name,' . $country->id],
            ]
        );

        if ($country->update($request->only('code', 'name'))) {
            session()->flash('status', __("The country :name has been changed.", ['name' => $country->name]));
        }

        return redirect()->route('admin.countries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country $country
     * @return RedirectResponse
     */
    public function destroy(Country $country)
    {
        try {
            $country->delete();

            session()->flash('status', __("The country :name has been deleted.", ['name' => $country->name]));
        } catch (QueryException $e) {
            session()->flash('status', __("The country :name could not be deleted.", ['name' => $country->name]));
        }

        return redirect()->route('admin.countries.index');
    }
}
