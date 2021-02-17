<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Team;
use App\Standing;
use App\Series;
use App\Season;
use App\Result;
use App\Race;
use App\Pick;
use App\League;
use App\Entry;
use App\Driver;
use App\Country;
use App\Circuit;

class MigrateOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:old {olddb=yfds_pickems}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old database data to new database structure';

    /**
     * Team color for each team (2017 only.)
     *
     * @var array
     */
    protected $teamColors = [
        'Ferrari'   => '#C30000',
        'McLaren'   => '#FF7B08',
        'Sauber'    => '#006EFF',
        'Renault'   => '#FFD800',
        'Toro Rosso'    => '#0000FF',
        'Red Bull'  => '#00007D',
        'Williams'  => '#FFFFFF',
        'Force India'   => '#FF80C7',
        'Mercedes GP'   => '#00CFBA',
        'Haas F1 Team'  => '#6C0000',
    ];

    /**
     * Country code for each driver.
     *
     * @var array
     */
    protected $driverCountry = [
        'Massa, Felipe'     => 'BR',
        'Räikkönen, Kimi'   => 'FI',
        'Hamilton, Lewis'   => 'GB',
        'Alonso, Fernando'  => 'ES',
        'Vettel, Sebastian' => 'DE',
        'Grosjean, Romain'  => 'FR',
        'Hülkenberg, Nico'  => 'DE',
        'Ericsson, Marcus'  => 'SE',
        'Magnussen, Kevin'  => 'DK',
        'Kvyat, Daniil'     => 'RU',
        'Verstappen, Max'   => 'NL',
        'Sainz Jr., Carlos' => 'ES',
        'Palmer, Jolyon'    => 'GB',
        'Wehrlein, Pascal'  => 'DE',
        'Vandoorne, Stoffel'    => 'BE',
        'Ocon, Esteban'     => 'FR',
        'Stroll, Lance'     => 'CA',
        'Giovinazzi, Antonio'   => 'IT',
        'Gasly, Pierre'     => 'FR',
        'Hartley, Brendon'  => 'NZ',
        'Ricciardo, Daniel' => 'AU',
        'Perez, Sergio'     => 'MX',
        'Bottas, Valtteri'  => 'FI',

        'Kovalainen, Heikki'    => 'FI',
        'Kubica, Robert'    => 'PL',
        'Heidfeld, Nick'    => 'DE',
        'Piquet, Nelsinho'  => 'BR',
        'Trulli, Jarno'     => 'IT',
        'Glock, Timo'       => 'DE',
        'Bourdais, Sebastien'   => 'FR',
        'Buemi, Sebastien'  => 'CH',
        'Webber, Mark'      => 'AU',
        'Rosberg, Nico'     => 'DE',
        'Nakajima, Kazuki'  => 'JP',
        'Sutil, Adrian'     => 'DE',
        'Fisichella, Giancarlo' => 'IT',
        'Button, Jenson'    => 'GB',
        'Barrichello, Rubens'   => 'BR',
        'Coulthard, David'  => 'GB',
        'Sato, Takuma'      => 'JP',
        'Davidson, Anthony' => 'GB',
        'Schumacher, Michael'   => 'DE',
        'Alguersauri, Jaime'    => 'ES',
        'Badoer, Luca'      => 'IT',
        'Liuzzi, Vitantonio'    => 'IT',
        'Kobayashi, Kamui'  => 'JP',
        'Petrov, Vitaly'    => 'RU',
        'Chandhok, Karun'   => 'IN',
        'Senna, Bruno'      => 'BR',
        'Rosa, Pedro de la' => 'ES',
        'Grassi, Luca di'   => 'IT',
        'Maldonado, Pastor' => 'VE',
        'Resta, Paul di'    => 'DE',
        'd\'Ambrosio, Jerome'   => 'BE',
        'Karthikeyan, Narain'   => 'IN',
        'Vergne, Jean-Eric' => 'FR',
        'Pic, Charles'      => 'FR',
        'Gutierrez, Esteban'    => 'MX',
        'Garde, Giedo van der'  => 'NL',
        'Bianchi, Jules'    => 'FR',
        'Chilton, Max'      => 'GB',
        'Nasr, Felipe'      => 'BR',
        'Stevens, Will'     => 'GB',
        'Merhi, Roberto'    => 'ES',
        'Haryanto, Rio'     => 'ID',
    ];

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
        if (!$this->isDatabaseEmpty()) {
            $this->error('Database was not empty. Stopping.');
            return 1;
        }

        $oldDatabase = $this->argument('olddb');

        $this->migrate(
            $oldDatabase,
            [
            [
            'table'     => 'players',
            'model'     => User::class,
            'fields'    => [
                'id'        => 'id',
                'name'      => 'username',
                'username'  => 'username',
                'password'  => function ($row) {
                    return bcrypt($row->password);
                },
                'email'     => function ($row) {
                    return empty($row->email) ? null : $row->email;
                },
                'reminder'  => function ($row) {
                    return !empty($row->email);
                },
                'active'    => 'active',
                'is_admin'  => function ($row) {
                    return $row->id == 1 ? 1 : 0;
                },
            ],
            ],
            [
            'table'     => 'teams',
            'model'     => Team::class,
            'fields'    => [
                'id'        => 'id',
                'name'      => 'name',
                'country_id'    => null,
                'active'    => 'active',
            ],
            ],
            [
            'table'     => 'series',
            'model'     => Series::class,
            'fields'    => [
                'id'        => 'id',
                'name'      => 'name',
            ],
            ]
            ]
        );

        $this->migrate(
            $oldDatabase,
            [
            [
            'table'     => 'seasons',
            'model'     => Season::class,
            'fields'    => [
                'id'        => 'id',
                'series_id' => Series::first()->id,
                'start_year'    => 'start_year',
                'end_year'  => function ($row) {
                    return $row->end_year ? $row->end_year : $row->start_year;
                },
            ],
            ],
            [
            'table'     => 'series',
            'model'     => League::class,
            'fields'    => [
                'id'        => 'id',
                'series_id' => 'id',
                'name'      => 'name',
            ],
            ],
            [
            'table'     => 'countries',
            'orderBy'   => 'code',
            'model'     => Country::class,
            'fields'    => [
                'code'      => 'code',
                'name'      => 'country',
            ],
            ],
            ]
        );

        $this->migrate(
            $oldDatabase,
            [
            [
            'table'     => 'drivers',
            'model'     => Driver::class,
            'fields'    => [
                'id'        => 'id',
                'first_name'    => function ($row) {
                    return trim(explode(',', $row->name)[1]);
                },
                'last_name' => function ($row) {
                    return trim(explode(',', $row->name)[0]);
                },
                'country_id'    => function ($row) {
                    return isset($this->driverCountry[ trim($row->name) ]) ? Country::where('code', $this->driverCountry[ trim($row->name) ])->first()->id : null;
                },
                'active'    => 'active',
            ],
            ],
            [
            'table'     => 'circuits',
            'model'     => Circuit::class,
            'fields'    => [
                'id'        => 'id',
                'name'      => 'name',
                'length'    => 'length',
                'city'      => function ($row) {
                    return trim(explode(',', $row->city)[0]);
                },
                'area'      => function ($row) {
                    $pos = strpos($row->city, ',');
                    return $pos === false ? null : trim(substr($row->city, $pos + 1));
                },
                'country_id'    => function ($row) {
                    return Country::where('code', $row->country)->first()->id;
                },
            ],
            ],
            [
            'table'     => 'entries',
            'model'     => Entry::class,
            'fields'    => [
                'id'        => 'id',
                'season_id' => 'seasons_id',
                'team_id'   => 'teams_id',
                'driver_id' => 'drivers_id',
                'car_number'    => 'car_number',
                'active'    => 'active',
            ],
            ],
            [
            'table'     => 'races',
            'model'     => Race::class,
            'fields'    => [
                'id'        => 'id',
                'season_id' => 'seasons_id',
                'circuit_id'    => 'circuits_id',
                'name'      => 'name',
                'weekend_start' => function ($row) {
                    return preg_match('/ 00:00:00$/', $row->weekend_start) ? date('Y-m-d H:i:s', strtotime('-2 days', strtotime($row->raceday))) : $row->weekend_start;
                },
                'race_day'  => 'raceday',
            ],
            ],
            [
            'table'     => 'results',
            'orderBy'   => 'races_id',
            'model'     => Result::class,
            'fields'    => [
                'rank'      => 'rank',
                'race_id'   => 'races_id',
                'entry_id'  => 'entries_id',
            ],
            ],
            ]
        );

        $this->attachAllUsersToLeagues();

        $this->completeEntryData();

        $this->migrate(
            $oldDatabase,
            [
            [
            'table'     => 'picks',
            'orderBy'   => 'races_id',
            'model'     => Pick::class,
            'fields'    => [
                'race_id'       => 'races_id',
                'entry_id'      => 'entries_id',
                'user_id'       => 'players_id',
                'rank'          => 'rank',
                'carry_over'        => 'carry_over',
            ],
            ],
            ]
        );

        return 0;
    }

    /**
     * Is the database empty so we can migrate?
     *
     * @return boolean
     */
    protected function isDatabaseEmpty()
    {
        return
            User::count() == 0
        and
            Team::count() == 0
        and
            Standing::count() == 0
        and
            Series::count() == 0
        and
            Season::count() == 0
        and
            Result::count() == 0
        and
            Race::count() == 0
        and
            Pick::count() == 0
        and
            League::count() == 0
        and
            Entry::count() == 0
        and
            Driver::count() == 0
        and
            Country::count() == 0
        and
            Circuit::count() == 0
        ;
    }

    /**
     * Migrate tables from the old database.
     *
     * @param string $oldDatabase
     * @param array  $mappings
     *
     * @return void
     */
    protected function migrate(string $oldDatabase, array $mappings)
    {
        foreach ($mappings as $mapping) {
            $oldTable   = $mapping['table'];
            $orderBy    = isset($mapping['orderBy']) ? $mapping['orderBy'] : 'id';

            $this->info("Migrating {$oldDatabase}.{$oldTable} table.");

            $table = DB::table("{$oldDatabase}.{$oldTable}")->orderBy($orderBy);

            $this->output->progressStart($table->count());

            $rows = $table->get();

            foreach ($rows as $row) {
                $model = new $mapping['model']();

                foreach ($mapping['fields'] as $newField => $oldField) {
                    if (is_callable($oldField)) {
                        $model->{$newField} = $oldField($row);
                    } elseif (property_exists($row, $oldField)) {
                        $model->{$newField} = $row->{$oldField};
                    } else {
                        $model->{$newField} = $oldField;
                    }
                }

                $model->save();

                $this->output->progressAdvance();
            }

            $this->output->progressFinish();
        }
    }

    /**
     * Attach all users to leagues.
     *
     * @return void
     */
    protected function attachAllUsersToLeagues()
    {
        $this->info('Attaching all users to leagues.');

        $users      = User::all();
        $leagues    = League::pluck('id');

        foreach ($users as $user) {
            $user->leagues()->attach($leagues);
        }
    }

    /**
     * Add data to empty fields of each entry.
     *
     * @return void
     */
    protected function completeEntryData()
    {
        $this->info('Completing entry data with colors and abbreviations.');

        $entries = Entry::all();

        foreach ($entries as $entry) {
            $entry->abbreviation    = strtoupper(substr(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $entry->driver->last_name), 0, 3));

            $entry->color       = isset($this->teamColors[ $entry->team->name ]) ? $this->teamColors[ $entry->team->name ] : null;

            $entry->save();
        }
    }
}
