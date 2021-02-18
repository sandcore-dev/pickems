<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Country;
use Illuminate\View\View;

class TeamsController extends Controller
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
        return view('admin.teams.index')->with('teams', Team::with(['country', 'entries'])->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.teams.create')->with('countries', Country::all());
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
                'name' => ['required', 'min:2', 'unique:teams'],
                'country_id' => ['required', 'integer', 'exists:countries,id'],
                'active' => ['boolean'],
            ]
        );

        if ($team = Team::create($request->only('name', 'active', 'country_id'))) {
            session()->flash('status', __("The team :name has been added.", ['name' => $team->name]));
        }

        return redirect()->route('admin.teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Team $teams
     * @return Factory|Application|View
     */
    public function show(Team $team)
    {
        return view('admin.teams.show')->with('team', $team);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $teams
     * @return Factory|Application|View
     */
    public function edit(Team $team)
    {
        return view('admin.teams.edit')->with(
            [
                'team' => $team,
                'countries' => Country::all()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Team $teams
     * @return RedirectResponse
     */
    public function update(Request $request, Team $team)
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:teams,name,' . $team->id],
                'country_id' => ['required', 'integer', 'exists:countries,id'],
                'active' => ['boolean'],
            ]
        );

        if ($team->update($request->only('name', 'active', 'country_id'))) {
            session()->flash('status', __("The team :name has been changed.", ['name' => $team->name]));
        }

        return redirect()->route('admin.teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $teams
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Team $team)
    {
        try {
            $team->delete();

            session()->flash('status', __("The team :name has been deleted.", ['name' => $team->name]));
        } catch (QueryException $e) {
            session()->flash('status', __("The team :name could not be deleted.", ['name' => $team->name]));
        }

        return redirect()->route('admin.teams.index');
    }
}
