<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use App\Traits\UserSeasonsList;
use App\Models\League;
use App\Models\Season;
use App\Models\Standing;
use App\Models\User;
use Illuminate\View\View;

class SeasonGraphController extends Controller
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
     * Show the application dashboard.
     *
     * @param League $league
     * @param Season $season
     * @param User $user
     * @return Factory|Application|View
     */
    public function index(League $league, Season $season, User $user)
    {
        if (!$league->id or !auth()->user()->leagues->contains($league)) {
            $league = auth()->user()->leagues->first();
        }

        if (!$user->id or !$league->users->contains($user)) {
            $user = auth()->user();
        }

        $seasons = $this->getSeasons($league, $user, false);

        if ($seasons->isEmpty()) {
            return view('picks.error')->with('error', __("There are no seasons available."));
        }

        if (!$season->id or !$league->series->seasons->contains($season)) {
            $season = $seasons->first();
        }

        return view('statistics.season.index')->with(
            [
                'leagues' => auth()->user()->leagues,
                'seasons' => $seasons,
                'users' => Standing::with('user')->whereIn('race_id', $season->races->pluck('id'))->get()->users(),
                'currentLeague' => $league,
                'currentSeason' => $season,
                'currentUser' => $user,
                'chartData' => Standing::with(['league.users', 'race.circuit.country'])
                    ->byLeague($league)
                    ->bySeason($season)
                    ->byUser($user)
                    ->get()
                    ->getChartData(),
            ]
        );
    }
}
