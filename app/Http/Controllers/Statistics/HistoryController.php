<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use App\Models\League;
use App\Models\Standing;
use Illuminate\View\View;

class HistoryController extends Controller
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

        return view('statistics.history.index')->with(
            [
                'leagues' => auth()->user()->leagues,
                'currentLeague' => $league,

                'bestPickems' => $this->getBestPickems($league),
                'bestCarryover' => $this->getBestPickems($league, true),

                'highestPoints' => $this->getHighestPoints($league),
            ]
        );
    }

    /**
     * Get best pickems data.
     *
     * @param League $league
     * @param boolean $carryOverOnly
     *
     * @return Collection
     */
    public function getBestPickems(League $league, bool $carryOverOnly = false)
    {
        $carryOver = [1, $carryOverOnly];

        $maxPositionsCorrect = Standing::byLeague($league)->whereIn('carry_over', $carryOver)->max('total');

        return Standing::with(['user', 'race.season', 'race.circuit.country'])->byLeague($league)
            ->where('total', $maxPositionsCorrect)
            ->whereIn('carry_over', $carryOver)
            ->orderBy('positions_correct', 'desc')
            ->orderBy('picked', 'desc')
            ->get();
    }

    /**
     * Get highest points in a season.
     *
     * @param League $league
     * @return Collection
     */
    public function getHighestPoints(League $league)
    {
        $maxPoints = Standing::byLeague($league)->max('total_overall');

        return Standing::with(['user', 'race.season', 'race.circuit.country'])->byLeague($league)
            ->where('total_overall', $maxPoints)
            ->orderBy('total_positions_correct', 'desc')
            ->orderBy('total_picked', 'desc')
            ->get();
    }
}
