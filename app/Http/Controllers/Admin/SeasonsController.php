<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\Season;
use Illuminate\View\View;

class SeasonsController extends Controller
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
     * @param Request
     *
     * @return Factory|Application|View
     */
    public function index(Request $request)
    {
        $series = $request->series ? Series::findOrFail($request->series) : Series::first();

        $series->load('seasons.races');

        return view('admin.seasons.index')->with(
            [
                'currentSeries' => $series,
                'series' => Series::all(),
                'seasons' => Season::with('races')->where('series_id', $series->id)->paginate(),
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
    public function create(Request $request)
    {
        $series = Series::findOrFail($request->series);

        return view('admin.seasons.create')->with('series', $series);
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
                'series_id' => ['bail', 'required', 'exists:series,id'],
                'start_year' => ['required', 'integer', 'between:1970,9999'],
                'end_year' => ['required', 'integer', 'between:1970,9999', 'gte:start_year'],
                'picks_max' => ['required', 'integer', 'between:' . config('picks.min') . ',' . config('picks.max')],
            ]
        );

        $seasonExists = Season::where('series_id', $request->input('series_id'))
            ->where('start_year', $request->input('start_year'))
            ->where('end_year', $request->input('end_year'))
            ->count();

        if ($seasonExists) {
            return redirect()->back()->withInput()->withErrors(['start_year' => 'This season already exists.']);
        }

        if ($season = Season::create($request->only('series_id', 'start_year', 'end_year', 'picks_max'))) {
            session()->flash('status', __("The season :name has been added.", ['name' => $season->name]));
        }

        return redirect()->route('admin.seasons.index', ['series' => $request->series_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param Season $season
     * @return Factory|Application|View
     */
    public function show(Season $season)
    {
        return view('admin.seasons.show')->with('season', $season);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Season $season
     * @return Factory|Application|View
     */
    public function edit(Season $season)
    {
        return view('admin.seasons.edit')->with('season', $season);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Season $season
     * @return RedirectResponse
     */
    public function update(Request $request, Season $season)
    {
        $request->validate(
            [
                'start_year' => ['required', 'integer', 'between:1970,9999'],
                'end_year' => ['required', 'integer', 'between:1970,9999', 'gte:start_year'],
                'picks_max' => ['required', 'integer', 'between:' . config('picks.min') . ',' . config('picks.max')],
            ]
        );

        $seasonExists = Season::where('series_id', $season->series->id)
            ->where('start_year', $request->input('start_year'))
            ->where('end_year', $request->input('end_year'))
            ->where('id', '!=', $season->id)
            ->count();

        if ($seasonExists) {
            return redirect()->back()->withInput()->withErrors(['start_year' => 'This season already exists.']);
        }

        if ($season->update($request->only('start_year', 'end_year', 'picks_max'))) {
            session()->flash('status', __("The season :name has been changed.", ['name' => $season->name]));
        }

        return redirect()->route('admin.seasons.index', ['series' => $season->series->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Season $season
     * @return RedirectResponse
     */
    public function destroy(Season $season)
    {
        try {
            $season->delete();

            session()->flash('status', __("The season :name has been deleted.", ['name' => $season->name]));
        } catch (QueryException $e) {
            session()->flash('status', __("The season :name could not be deleted.", ['name' => $season->name]));
        }

        return redirect()->route('admin.seasons.index', ['series' => $season->series->id]);
    }
}
