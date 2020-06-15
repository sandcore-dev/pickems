<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use App\League;
use App\Standing;
use Illuminate\View\View;

class AllTimeController extends Controller
{
    /**
     * Minimum number of seasons to be listed in the all-time rankings.
     *
     * @var integer
     */
    protected $minSeasons = 5;

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

        return view('statistics.alltime.index')->with(
            [
                'leagues' => auth()->user()->leagues,
                'currentLeague' => $league,

                'averages' => $this->getAverages($league),
            ]
        );
    }

    /**
     * Get end-of-season data for each user.
     *
     * @param League $league
     * @return Collection
     */
    public function getAverages(League $league)
    {
        $lastRaces = $this->getLastRaceEachSeason($league);

        $finalStandings = Standing::with('user')->byLeague($league)->whereIn('race_id', $lastRaces)->get();

        $mappedByUser = $finalStandings->mapToGroups(
            function ($item) {
                return [$item->user_id => $item];
            }
        );

        $minSeasons = $mappedByUser->reject(
            function ($value) {
                return $value->count() < $this->minSeasons;
            }
        );

        $sortedByAverages = $minSeasons->sort(
            function ($a, $b) {
                return $a->avg('rank') <=> $b->avg('rank');
            }
        );

        return $sortedByAverages;
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
