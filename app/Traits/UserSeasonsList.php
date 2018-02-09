<?php

namespace App\Traits;

use App\League;
use App\Pick;
use App\User;

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
     * @return	\Illuminate\Database\Eloquent\Collection
     */
    protected function getSeasons( League $league, User $user = null, bool $includeFutureSeasons = true )
    {
		if( $this->seasons[ $league->id ] )
			return $this->seasons[ $league->id ];
		
		$seasons	= [];
		
		if( !$user )
			$user = auth()->user();
		
		foreach( $league->series->seasons as $season )
		{
			if( $season->end_year < date('Y') )
			{
				if( Pick::byUser( $user )->whereIn( 'race_id', $season->races->pluck('id') )->count() )
					$seasons[ $season->id ] = $season;
			}
			elseif( $includeFutureSeasons )
			{
				$seasons[] = $season;
			}
		}
		
		$this->seasons[ $league->id ] = collect($seasons);
		
		return $this->seasons[ $league->id ];
    }
}
