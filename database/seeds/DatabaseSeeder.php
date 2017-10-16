<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call( UsersTableSeeder::class );
        
        $this->call( SeriesTableSeeder::class );
        $this->call( SeasonsTableSeeder::class );
        
        $this->call( CountriesTableSeeder::class );
        $this->call( CircuitsTableSeeder::class );
        
        $this->call( DriversTableSeeder::class );
        $this->call( TeamsTableSeeder::class );

        $this->call( EntriesTableSeeder::class );
        $this->call( RacesTableSeeder::class );

        $this->call( LeaguesTableSeeder::class );

        $this->call( LeagueSeasonTableSeeder::class );
        $this->call( LeagueUserTableSeeder::class );
        
        $this->call( PicksTableSeeder::class );
        $this->call( ResultsTableSeeder::class );
    }
}
