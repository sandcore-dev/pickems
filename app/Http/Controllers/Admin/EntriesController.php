<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Series;
use App\Season;
use App\Team;
use App\Driver;
use App\Entry;
use App\Rules\ValidHexValue;
use Illuminate\View\View;

class EntriesController extends Controller
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
    public function index(Request $request)
    {
        if ($request->series) {
            $series = Series::has('seasons')->findOrFail($request->series);
            $season = $series->seasons()->first();
        } elseif ($request->season) {
            $season = Season::findOrFail($request->season);
            $series = $season->series;
        } else {
            $series = Series::has('seasons')->first();
            $season = $series->seasons()->first();
        }
    
        return view('admin.entries.index')->with(
            [
            'currentSeries' => $series,
            'series'    => Series::has('seasons')->get(),
            'currentSeason' => $season,
            'seasons'   => $series->seasons,
            'entries'   => Entry::with([ 'team', 'driver', 'results', 'picks' ])->where('season_id', $season->id)->paginate(30),
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
        $season = Season::findOrFail($request->season);
        
        return view('admin.entries.create')->with(
            [
            'season'    => $season,
            'teams'     => Team::where('active', 1)->get(),
            'drivers'   => Driver::where('active', 1)->get(),
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
        /** @noinspection PhpUndefinedMethodInspection */
        $request->validate(
            [
            'season_id'     => [ 'bail', 'required', 'integer', 'exists:seasons,id' ],
            'car_number'        => [ 'required', 'numeric' ],
            'team_id'       => [ 'required', 'integer', 'exists:teams,id' ],
            'driver_id'     => [ 'required', 'integer', 'exists:drivers,id' ],
            'abbreviation'      => [ 'required', 'size:3' ],
            'color'         => [ 'required', new ValidHexValue() ],
            'active'        => [ 'boolean' ],
            ]
        );
        
        if (Entry::where('season_id', $request->input('season_id'))->where('team_id', $request->input('team_id'))->where('driver_id', $request->input('driver_id'))->count()) {
            return redirect()->back()->withInput()->withErrors([ 'car_number' => __('This entry already exists.') ]);
        }
        
        if (Entry::where('season_id', $request->input('season_id'))->where('team_id', $request->input('team_id'))->where('abbreviation', $request->input('abbreviation'))->count()) {
            return redirect()->back()->withInput()->withErrors([ 'abbreviation' => __('The abbreviation is already in use for this team.') ]);
        }
        
        if ($entry = Entry::create($request->only('season_id', 'car_number', 'color', 'team_id', 'driver_id', 'abbreviation', 'active'))) {
            session()->flash('status', __("The entry :name has been added.", [ 'name' => $entry->car_number ]));
        }
        
        return redirect()->route('admin.entries.index', [ 'season' => $request->season_id ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Entry $entry
     * @return Factory|Application|View
     */
    public function show(Entry $entry)
    {
        return view('admin.entries.show')->with('entry', $entry);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Entry $entry
     * @return Factory|Application|View
     */
    public function edit(Entry $entry)
    {
        return view('admin.entries.edit')->with(
            [
            'entry'     => $entry,
            'teams'     => Team::where('active', 1)->get(),
            'drivers'   => Driver::where('active', 1)->get(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Entry $entry
     * @return RedirectResponse
     */
    public function update(Request $request, Entry $entry)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $request->validate(
            [
            'car_number'        => [ 'required', 'numeric' ],
            'team_id'       => [ 'required', 'integer', 'exists:teams,id' ],
            'driver_id'     => [ 'required', 'integer', 'exists:drivers,id' ],
            'color'         => [ 'required', new ValidHexValue() ],
            'abbreviation'      => [ 'required', 'size:3' ],
            'active'        => [ 'boolean' ],
            ]
        );
        
        if (Entry::where('season_id', $request->input('season_id'))->where('team_id', $request->input('team_id'))->where('driver_id', $request->input('driver_id'))->where('id', '!=', $entry->id)->count()) {
            return redirect()->back()->withInput()->withErrors([ 'car_number' => __('This entry already exists.') ]);
        }
        
        if (Entry::where('season_id', $request->input('season_id'))->where('team_id', $request->input('team_id'))->where('abbreviation', $request->input('abbreviation'))->where('id', '!=', $entry->id)->count()) {
            return redirect()->back()->withInput()->withErrors([ 'abbreviation' => __('The abbreviation is already in use for this team.') ]);
        }
        
        if ($entry->update($request->only('season_id', 'car_number', 'abbreviation', 'color', 'team_id', 'driver_id', 'active'))) {
            session()->flash('status', __("The entry :name has been changed.", [ 'name' => $entry->car_number ]));
        }
        
        return redirect()->route('admin.entries.index', [ 'season' => $entry->season->id ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Entry $entry
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Entry $entry)
    {
        try {
            $entry->delete();
            
            session()->flash('status', __("The entry :name has been deleted.", [ 'name' => $entry->car_number ]));
        } catch (QueryException $e) {
            session()->flash('status', __("The entry :name could not be deleted.", [ 'name' => $entry->car_number ]));
        }
            
        return redirect()->route('admin.entries.index', [ 'season' => $entry->season->id ]);
    }

    /**
     * Populate season with entries from previous season.
     *
     * @param Season $season Current season
     * @return RedirectResponse
     */
    public function populate(Season $season)
    {
        if ($this->copyEntriesFromPreviousSeasonTo($season)) {
            return redirect()->route('admin.entries.index')->with('status', __('The entries from :from are copied to :to.', [ 'from' => $season->previous->name, 'to' => $season->name ]));
        } else {
            return redirect()->route('admin.entries.index')->with('error', __('An error occurred when trying to copy entries. Is the destination season empty?'));
        }
    }
    
    /**
     * Copy races to the given season from the previous one.
     *
     * @param Season $season
     * @return boolean
     */
    protected function copyEntriesFromPreviousSeasonTo(Season $season)
    {
        if (!$season->entries->isEmpty()) {
            return false;
        }
        
        if ($season->previous->entries->isEmpty()) {
            return false;
        }
        
        foreach ($season->previous->entries as $entry) {
            if (!$entry->active) {
                continue;
            }
                
            $newEntry = $entry->replicate();
            
            $newEntry->season_id = $season->id;
            
            $newEntry->save();
        }
        
        return true;
    }
}
