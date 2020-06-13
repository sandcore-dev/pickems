<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

use App\League;
use App\Pick;
use App\User;
use App\Season;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$user		= auth()->user();
    	
    	$league		= $user->leagues->first();
    	
    	if( !$league )
			return view('picks.error')->with( 'error', "You haven't joined any leagues." );
    	
    	return $this->league( $league );
    }
    
    /**
     * Use league data to go to the default race.
     *
     * @param	\App\League	$league
     * 
     * @return	\Illuminate\Http\Response
     */
    public function league( League $league )
    {
    	$season	= $this->getSeasons( $league )->first();
    	
    	if( !$season )
			return view('picks.error')->with( 'error', "There are no seasons available." );

    	return $this->season( $league, $season );
    }
    
    /**
     * Use season data to go to the default race.
     *
     * @param	\App\League					$league
     * @param	\App\Season					$season
     * 
     * @return	\Illuminate\Http\Response
     */
    public function season( League $league, Season $season )
    {
		//
    }

    /**
     * Get seasons for the given user and league.
     * Those should be only future ones or the ones the user participated in.
     * 
     * @param	\App\League		$league
     * @param	\App\User|null	$user
     * @param	boolean			$includeFutureSeasons
     * 
     * @return	\Illuminate\Database\Eloquent\Collection of App\Season
     */
    protected function getSeasons( League $league, User $user = null, bool $includeFutureSeasons = true )
    {
		if( isset($this->seasons[ $league->id ]) )
			return $this->seasons[ $league->id ];
		
		$seasons = [];
		
		if( !$user )
			$user = auth()->user();
		
		$season_ids = DB::table('picks')
			->join( 'races', 'picks.race_id', '=', 'races.id' )
			->join( 'seasons', 'races.season_id', '=', 'seasons.id' )
			->where( 'seasons.series_id', $league->series_id )
			->where( 'seasons.end_year', '<', date('Y') )
			->where( 'picks.user_id', $user->id )
			->select('seasons.id')->distinct()->pluck('seasons.id');
		
		if( $includeFutureSeasons )
			$season_ids = $season_ids->concat(
				DB::table('seasons')
					->where( 'seasons.series_id', $league->series_id )
					->where( 'seasons.end_year', '>=', date('Y') )
					->select('seasons.id')->distinct()->pluck('seasons.id')
			);
			
		$seasons = Season::has('races')->whereIn( 'id', $season_ids )->get();
		
		$this->seasons[ $league->id ] = $seasons;
		
		return $this->seasons[ $league->id ];
    }
}
