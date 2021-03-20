<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Helpers\Date;
use App\Models\Series;
use App\Models\Season;
use App\Models\Circuit;
use App\Models\Race;
use Illuminate\View\View;

class RacesController extends Controller
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
     * @param Request $request
     * @return Factory|Application|View
     */
    public function index(Request $request)
    {
        if ($request->filled('series')) {
            $series = Series::has('seasons')->findOrFail($request->input('series'));
            $season = $series->seasons()->first();
        } elseif ($request->filled('season')) {
            $season = Season::findOrFail($request->input('season'));
            $series = $season->series;
        } else {
            $series = Series::has('seasons')->first();
            $season = $series->seasons()->first();
        }

        return view('admin.races.index')->with(
            [
                'currentSeries' => $series,
                'series' => Series::has('seasons')->get(),
                'currentSeason' => $season,
                'seasons' => $series->seasons,
                'races' => Race::with('results')->where('season_id', $season->id)->paginate(30),
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
        $season = Season::findOrFail($request->input('season'));

        return view('admin.races.create')->with(
            [
                'season' => $season,
                'circuits' => Circuit::all(),
            ]
        );
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
                'season_id' => ['bail', 'required', 'integer', 'exists:seasons,id'],
                'name' => ['required', 'min:2'],
                'circuit_id' => ['required', 'integer', 'exists:circuits,id'],
                'race_day_day' => ['required', 'numeric', 'between:1,31'],
                'race_day_month' => ['required', 'numeric', 'between:1,12'],
                'race_day_year' => ['required', 'numeric'],
                'weekend_start_day' => ['required', 'numeric', 'between:1,31'],
                'weekend_start_month' => ['required', 'numeric', 'between:1,12'],
                'weekend_start_year' => ['required', 'numeric'],
            ]
        );

        $race_day = Carbon::createFromDate(
            $request->input('race_day_year'),
            $request->input('race_day_month'),
            $request->input('race_day_day')
        );
        $weekend_start = Carbon::create(
            $request->input('weekend_start_year'),
            $request->input('weekend_start_month'),
            $request->input('weekend_start_day'),
            $request->input('weekend_start_hour'),
            $request->input('weekend_start_minute'),
            0
        );

        if ($weekend_start->greaterThan($race_day)) {
            return redirect()->back()->withInput()->withErrors(
                ['weekend_start' => __('The weekend start cannot be after race day.')]
            );
        }

        if (Race::where('season_id', $request->input('season_id'))->where(
            'circuit_id',
            $request->input('circuit_id')
        )->where('race_day', $race_day)->count()) {
            return redirect()->back()->withInput()->withErrors(['name' => __('This race already exists.')]);
        }

        $data = $request->only('season_id', 'name', 'circuit_id');

        $data['race_day'] = $race_day;
        $data['weekend_start'] = $weekend_start;

        if ($race = Race::create($data)) {
            session()->flash('status', __("The race :name has been added.", ['name' => $race->name]));
        }

        return redirect()->route('admin.races.index', ['season' => $request->season_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param Race $race
     * @return Factory|Application|View
     */
    public function show(Race $race)
    {
        return view('admin.races.show')->with('race', $race);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Race $race
     * @return Factory|Application|View
     */
    public function edit(Race $race)
    {
        return view('admin.races.edit')->with(
            [
                'race' => $race,
                'circuits' => Circuit::all(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Race $race
     * @return RedirectResponse
     */
    public function update(Request $request, Race $race)
    {
        $request->validate(
            [
                'name' => ['required', 'min:2'],
                'circuit_id' => ['required', 'integer', 'exists:circuits,id'],
                'race_day_day' => ['required', 'numeric', 'between:1,31'],
                'race_day_month' => ['required', 'numeric', 'between:1,12'],
                'race_day_year' => ['required', 'numeric'],
                'weekend_start_day' => ['required', 'numeric', 'between:1,31'],
                'weekend_start_month' => ['required', 'numeric', 'between:1,12'],
                'weekend_start_year' => ['required', 'numeric'],
            ]
        );

        $race_day = Carbon::createFromDate(
            $request->input('race_day_year'),
            $request->input('race_day_month'),
            $request->input('race_day_day')
        );
        $weekend_start = Carbon::create(
            $request->input('weekend_start_year'),
            $request->input('weekend_start_month'),
            $request->input('weekend_start_day'),
            $request->input('weekend_start_hour'),
            $request->input('weekend_start_minute'),
            0
        );

        if ($weekend_start->greaterThan($race_day)) {
            return redirect()->back()->withInput()->withErrors(
                ['weekend_start' => 'The weekend start cannot be after race day.']
            );
        }

        if (Race::where('season_id', $request->input('season_id'))->where(
            'circuit_id',
            $request->input('circuit_id')
        )->where('race_day', $race_day)->count()) {
            return redirect()->back()->withInput()->withErrors(['name' => 'This race already exists.']);
        }

        $data = $request->only('name', 'circuit_id');

        $data['race_day'] = $race_day;
        $data['weekend_start'] = $weekend_start;

        if ($race->update($data)) {
            session()->flash('status', __("The race :name has been changed.", ['name' => $race->name]));
        }

        return redirect()->route('admin.races.index', ['season' => $race->season->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Race $race
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Race $race)
    {
        try {
            $race->delete();

            session()->flash('status', __("The race :name has been deleted.", ['name' => $race->name]));
        } catch (QueryException $e) {
            session()->flash('status', __("The race :name could not be deleted.", ['name' => $race->name]));
        }

        return redirect()->route('admin.races.index', ['season' => $race->season->id]);
    }


    /**
     * Populate season with races from previous season.
     *
     * @param Season $season Current season
     * @return RedirectResponse
     */
    public function populate(Season $season)
    {
        if ($this->copyRacesFromPreviousSeasonTo($season)) {
            return redirect()->route('admin.races.index')->with(
                'status',
                __(
                    'The races from :from are copied to :to.',
                    [
                        'from' => $season->previous->name,
                        'to' => $season->name,
                    ]
                )
            );
        } else {
            return redirect()->route('admin.races.index')->with(
                'error',
                __(
                    'An error occurred when trying to copy races. Is the destination season empty?'
                )
            );
        }
    }

    /**
     * Copy races to the given season from the previous one.
     *
     * @param Season $season
     * @return boolean
     */
    protected function copyRacesFromPreviousSeasonTo(Season $season)
    {
        if (!$season->races->isEmpty()) {
            return false;
        }

        if ($season->previous->races->isEmpty()) {
            return false;
        }

        foreach ($season->previous->races as $race) {
            $newRace = $race->replicate();

            $newRace->season_id = $season->id;

            $newRace->weekend_start = Date::getClosestWeekdayNextYear($newRace->weekend_start);
            $newRace->race_day = Date::getClosestWeekdayNextYear($newRace->race_day);

            $newRace->save();
        }

        return true;
    }
}
