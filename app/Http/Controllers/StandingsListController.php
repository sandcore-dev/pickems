<?php

namespace App\Http\Controllers;

use App\Traits\UserSeasonsList;
use App\Models\League;
use App\Models\Season;
use App\Models\Race;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StandingsListController extends Controller
{
    use UserSeasonsList;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Use season data to go to the default race.
     *
     * @param League $league
     * @param Season $season
     * @return Factory|Application|RedirectResponse|View
     */
    public function season(League $league, Season $season)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $race = $season->races()->previousOrFirst();

        if (!$race->count()) {
            return view('picks.error')->with('error', __("There are no races available."));
        }

        return redirect()->route('standings.race', ['league' => $league->id, 'race' => $race->id]);
    }

    /**
     * Show the application dashboard.
     *
     * @param League $league
     * @param Race $race
     * @return Factory|Application|View
     */
    public function race(League $league, Race $race)
    {
        $user = auth()->user();

        if (!$user->leagues->contains($league)) {
            abort(404);
        }

        $league->load('standings.user');

        $standings = $league->standings->where('race_id', $race->id);

        return view('standings.index')->with(
            [
                'leagues' => $user->leagues,

                'currentLeague' => $league,
                'currentRace' => $race,

                'standings' => $standings,
            ]
        );
    }
}
