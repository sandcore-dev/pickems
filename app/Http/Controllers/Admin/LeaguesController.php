<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\League;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LeaguesController extends Controller
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
     * @param Request
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('admin.leagues.index')->with(
            [
            'leagues'   => League::paginate(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.leagues.create')->with('series', Series::all());
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
            'name'              => [ 'required', 'min:2', 'unique:leagues' ],
            'series_id'         => [ 'required', 'exists:series,id' ],
            'generate_token'    => [ 'boolean' ],
            ]
        );

        if ($league = League::create($request->only('name', 'series_id'))) {
            session()->flash('status', __("The league :name has been added.", [ 'name' => $league->name ]));

            if ($request->input('generate_token')) {
                $league->access_token = Str::random(10);
            }

            $league->save();
        }

        return redirect()->route('admin.leagues.index');
    }

    /**
     * Display the specified resource.
     *
     * @param League $league
     * @return Factory|Application|View
     */
    public function show(League $league)
    {
        return view('admin.leagues.show')->with('league', $league);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param League $league
     * @return Factory|Application|View
     */
    public function edit(League $league)
    {
        return view('admin.leagues.edit')->with('league', $league);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param League $league
     * @return RedirectResponse
     */
    public function update(Request $request, League $league)
    {
        $request->validate(
            [
            'name'              => [ 'required', 'min:2', 'unique:leagues,name,' . $league->id ],
            'generate_token'    => [ 'boolean' ],
            ]
        );

        if ($league->update($request->only('name'))) {
            session()->flash('status', __("The league :name has been changed.", [ 'name' => $league->name ]));
        }

        if ($request->input('generate_token')) {
            $league->update([ 'access_token' => Str::random(10) ]);
        }

        return redirect()->route('admin.leagues.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param League $league
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(League $league)
    {
        try {
            $league->delete();

            session()->flash('status', __("The league :name has been deleted.", [ 'name' => $league->name ]));
        } catch (QueryException $e) {
            session()->flash('status', __("The league :name could not be deleted.", [ 'name' => $league->name ]));
        }

        return redirect()->route('admin.leagues.index');
    }
}
