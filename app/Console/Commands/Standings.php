<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Race;
use App\League;

class Standings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'standings {league} {offset=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the standings with bbCode formatting.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $leagueName = $this->argument('league');
        $leagues    = League::where('name', $leagueName)->get();
        $offset     = $this->argument('offset');
        $race       = Race::previousOrFirst($offset);

        if ($leagues->isEmpty()) {
            $this->error("League {$leagueName} not found.");
            return;
        }

        $league = $leagues->first();

        $league->load('standings.user');

        $standings = $league->standings->where('race_id', $race->id);

        $this->line((string) view('standings.bbcode')->with('standings', $standings));
    }
}
