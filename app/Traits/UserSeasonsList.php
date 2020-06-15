<?php

namespace App\Traits;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\League;
use App\User;
use App\Season;
use Illuminate\View\View;

trait UserSeasonsList
{
    /**
     * Cache the result of getSeasons.
     *
     * @var array of \Illuminate\Support\Collection
     */
    protected $seasons;

    /**
     * Go to the default race.
     *
     * @return Factory|Application|Response|View
     */
    public function index()
    {
        $user = auth()->user();

        $league = $user->leagues->first();

        if (!$league) {
            return view('picks.error')->with('error', "You haven't joined any leagues.");
        }

        return $this->league($league);
    }

    /**
     * Use league data to go to the default race.
     *
     * @param League $league
     *
     * @return Factory|Application|Response|View
     */
    public function league(League $league)
    {
        $season = $this->getSeasons($league)->first();

        if (!$season) {
            return view('picks.error')->with('error', "There are no seasons available.");
        }

        return $this->season($league, $season);
    }

    /**
     * Get seasons for the given user and league.
     * Those should be only future ones or the ones the user participated in.
     *
     * @param League $league
     * @param User|null $user
     * @param bool $includeFutureSeasons
     *
     * @return Collection of App\Season
     */
    protected function getSeasons(League $league, User $user = null, bool $includeFutureSeasons = true)
    {
        if (isset($this->seasons[$league->id])) {
            return $this->seasons[$league->id];
        }

        if (!$user) {
            $user = auth()->user();
        }

        $season_ids = DB::table('picks')
            ->join('races', 'picks.race_id', '=', 'races.id')
            ->join('seasons', 'races.season_id', '=', 'seasons.id')
            ->where('seasons.series_id', $league->series_id)
            ->where('seasons.end_year', '<', date('Y'))
            ->where('picks.user_id', $user->id)
            ->select('seasons.id')->distinct()->pluck('seasons.id');

        if ($includeFutureSeasons) {
            $season_ids = $season_ids->concat(
                DB::table('seasons')
                    ->where('seasons.series_id', $league->series_id)
                    ->where('seasons.end_year', '>=', date('Y'))
                    ->select('seasons.id')->distinct()->pluck('seasons.id')
            );
        }

        $seasons = Season::has('races')->whereIn('id', $season_ids)->get();

        $this->seasons[$league->id] = $seasons;

        return $this->seasons[$league->id];
    }
}
