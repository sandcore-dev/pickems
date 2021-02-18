<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use App\Models\League;
use App\Models\Standing;
use Illuminate\View\View;

class FameController extends Controller
{
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
     * @return Factory|Application|View
     */
    public function index(League $league)
    {
        if (!$league->id or !auth()->user()->leagues->contains($league)) {
            $league = auth()->user()->leagues->first();
        }

        return view('statistics.fame.index')->with(
            [
                'leagues' => auth()->user()->leagues,
                'currentLeague' => $league,

                'champions' => $this->getChampions($league),
            ]
        );
    }

    /**
     * Get champions.
     *
     * @param League $league
     * @return Collection
     */
    public function getChampions(League $league)
    {
        $lastRaces = $this->getLastRaceEachSeason($league);

        return Standing::with(['user', 'race.season'])
            ->byLeague($league)
            ->where('rank', 1)
            ->whereIn('race_id', $lastRaces)
            ->get()->mapToGroups(
                function ($item) {
                    return [$item->user_id => $item];
                }
            );
    }

    /**
     * Get the last race of each season of the specified league.
     *
     * @param League $league
     * @return array
     */
    protected function getLastRaceEachSeason(League $league)
    {
        $out = [];

        $league->loadMissing('series.seasons.races');

        foreach ($league->series->seasons as $season) {
            if ($last = $season->races->last()) {
                $out[] = $last->id;
            }
        }

        return $out;
    }
}
