<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\UserSeasonsList;
use App\Models\User;
use App\Models\League;
use App\Models\Season;
use App\Models\Race;
use App\Models\Pick;
use App\Rules\NotPickedYet;
use App\Rules\MaxPicksExceeded;
use Illuminate\View\View;

class PicksController extends Controller
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
        $race = $season->races()->nextOrLast();

        if (!$race->count()) {
            return view('picks.error')->with('error', __("There are no races available."));
        }

        return redirect()->route('picks.race', ['league' => $league->id, 'race' => $race->id]);
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
        /** @var User $user */
        $user = auth()->user();

        if (!$user->leagues->contains($league)) {
            abort(404);
        }

        $picks = Pick::with(['entry.driver.country', 'entry.team', 'race.results'])
            ->byUser($user)
            ->byRace($race)
            ->get();

        $entriesByTeam = $race->season->entries()
            ->with(['driver.country', 'team'])
            ->whereNotIn('id', $picks->pluck('entry_id'))
            ->get()
            ->getByTeam();

        return view('picks.index')->with(
            [
                'seasons' => $this->getSeasons($league),

                'currentLeague' => $league,
                'currentRace' => $race->load('season.races.circuit.country'),

                'entriesByTeam' => $entriesByTeam,
                'picks' => $picks->padMissing($race->season->picks_max),
            ]
        );
    }

    /**
     * Add pick.
     *
     * @param League $league
     * @param Race $race
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(League $league, Race $race, Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        if (!$user->leagues->contains($league)) {
            abort(404);
        }

        if (!$league->series->seasons->contains($race->season)) {
            abort(404);
        }

        if ($race->weekend_start->lte(Carbon::now())) {
            abort(404);
        }

        $request->validate(
            [
                'entry' => [
                    'required',
                    'integer',
                    'exists:entries,id',
                    new NotPickedYet($user, $race),
                    new MaxPicksExceeded($user, $race, $race->season->picks_max),
                ],
            ]
        );

        Pick::create(
            [
                'race_id' => $race->id,
                'entry_id' => $request->entry,
                'user_id' => $user->id,
                'rank' => $this->getHighestAvailableRank($user, $race),
                'carry_over' => 0,
            ]
        );

        return redirect()->back();
    }

    /**
     * Remove pick.
     *
     * @param League $league
     * @param Race $race
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function delete(League $league, Race $race, Request $request)
    {
        $user = auth()->user();

        if (!$user->leagues->contains($league)) {
            abort(404);
        }

        if (!$league->series->seasons->contains($race->season)) {
            abort(404);
        }

        if ($race->weekend_start->lte(Carbon::now())) {
            return redirect()->back();
        }

        $request->validate(
            [
                'pick' => ['required', 'integer'],
            ]
        );

        $pick = Pick::findOrFail($request->pick);

        if ($pick->race_id == $race->id and $pick->user_id == $user->id) {
            $pick->delete();
        }

        return redirect()->back();
    }

    /**
     * Get the highest available rank for this pick.
     *
     * @param User $user
     * @param Race $race
     * @return integer
     */
    public function getHighestAvailableRank(User $user, Race $race)
    {
        $ranks = Pick::byRaceAndUser($race, $user)->orderBy('rank', 'asc')->pluck('rank');

        foreach ($ranks as $key => $rank) {
            if ($key + 1 == $rank) {
                continue;
            }

            return $rank - 1;
        }

        return $ranks->max() + 1;
    }
}
