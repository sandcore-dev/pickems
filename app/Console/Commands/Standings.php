<?php

namespace App\Console\Commands;

use App\Models\Standing;
use Illuminate\Console\Command;
use App\Models\Race;
use App\Models\League;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableStyle;

class Standings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'standings {league} {offset=0}
                                {--ascii : Output as an ASCII table instead}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the standings with bbCode formatting or as an ASCII table.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $leagueName = $this->argument('league');
        $leagues = League::where('name', $leagueName)->get();
        $offset = $this->argument('offset');
        $race = Race::previousOrFirst($offset);

        if ($leagues->isEmpty()) {
            $this->error("League {$leagueName} not found.");
            return 1;
        }

        $league = $leagues->first();

        $league->load('standings.user');

        $standings = $league->standings->where('race_id', $race->id);

        if ($this->option('ascii')) {
            $number = $standings->count()
                ? $standings->first()->race->season->picks_max
                : config('picks.max');

            $this->table(
                [
                    [
                        new TableCell(
                            '',
                            [
                                'colspan' => 3,
                            ]
                        ),
                        new TableCell(
                            __('Overall'),
                            [
                                'colspan' => 3,
                                'style' => new TableCellStyle(['align' => 'left', 'fg' => 'green']),
                            ]
                        ),
                        new TableCell(
                            __('Race'),
                            [
                                'colspan' => 3,
                                'style' => new TableCellStyle(['align' => 'left', 'fg' => 'green']),
                            ]
                        ),
                    ],
                    [
                        __('Rank'),
                        '+/-',
                        __('Name'),
                        __('Total'),
                        __('Finish'),
                        __('Top :number', ['number' => $number]),
                        __('Total'),
                        __('Finish'),
                        __('Top :number', ['number' => $number]),
                    ],
                ],
                $standings->map(
                    function (Standing $standing) {
                        return [
                            $standing->rank,
                            $standing->rank_moved,
                            $standing->user->name,
                            $standing->total_overall,
                            $standing->total_positions_correct,
                            $standing->total_picked,
                            $standing->total,
                            $standing->positions_correct,
                            $standing->picked,
                        ];
                    }
                ),
                'default',
                [
                    (new TableStyle())->setPadType(STR_PAD_LEFT),
                    (new TableStyle())->setPadType(STR_PAD_BOTH),
                    (new TableStyle())->setPadType(STR_PAD_RIGHT),
                    (new TableStyle())->setPadType(STR_PAD_LEFT),
                    (new TableStyle())->setPadType(STR_PAD_LEFT),
                    (new TableStyle())->setPadType(STR_PAD_LEFT),
                    (new TableStyle())->setPadType(STR_PAD_LEFT),
                    (new TableStyle())->setPadType(STR_PAD_LEFT),
                    (new TableStyle())->setPadType(STR_PAD_LEFT),
                ]
            );

            return 0;
        }

        $this->line((string)view('standings.bbcode')->with('standings', $standings));

        return 0;
    }
}
