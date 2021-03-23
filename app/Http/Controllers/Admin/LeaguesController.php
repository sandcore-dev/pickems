<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Models\Series;
use App\Models\League;
use Illuminate\Support\Str;

class LeaguesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(): Renderable
    {
        return view('admin.leagues.index')
            ->with(
                [
                    'leagues' => League::paginate(),
                ]
            );
    }

    public function create(): Renderable
    {
        return view('admin.leagues.create')
            ->with(
                [
                    'series' => Series::all(),
                ]
            );
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:leagues'],
                'series_id' => ['required', 'exists:series,id'],
                'generate_token' => ['boolean'],
                'championship_picks' => ['boolean'],
            ]
        );

        if ($league = League::create($request->only('name', 'series_id', 'championship_picks'))) {
            session()->flash('status', __('The league :name has been added.', ['name' => $league->name]));

            if ($request->input('generate_token')) {
                $league->access_token = Str::random(10);
            }

            $league->save();
        }

        return redirect()->route('admin.leagues.index');
    }

    public function show(League $league): Renderable
    {
        return view('admin.leagues.show')
            ->with(
                [
                    'league' => $league,
                ]
            );
    }

    public function edit(League $league): Renderable
    {
        return view('admin.leagues.edit')
            ->with(
                [
                    'league' => $league,
                ]
            );
    }

    public function update(Request $request, League $league): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'min:2', 'unique:leagues,name,' . $league->id],
                'generate_token' => ['boolean'],
            ]
        );

        if ($league->update($request->only('name', 'championship_picks_enabled'))) {
            session()->flash('status', __("The league :name has been changed.", ['name' => $league->name]));
        }

        if ($request->input('generate_token')) {
            $league->update(['access_token' => Str::random(10)]);
        }

        return redirect()->route('admin.leagues.index');
    }

    public function destroy(League $league): RedirectResponse
    {
        try {
            $league->delete();

            session()->flash('status', __("The league :name has been deleted.", ['name' => $league->name]));
        } catch (QueryException $e) {
            session()->flash('status', __("The league :name could not be deleted.", ['name' => $league->name]));
        }

        return redirect()->route('admin.leagues.index');
    }
}
