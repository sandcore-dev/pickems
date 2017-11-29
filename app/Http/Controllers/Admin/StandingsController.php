<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Season;
use App\Standing;
use App\User;
use App\League;
use App\Pick;
use App\Result;
use App\Race;

class StandingsController extends Controller
{
	/**
	 * Picks editor controller.
	 *
	 * @var \App\Http\Controllers\Controller\Admin\PicksEditController
	 */
	protected $picksController;
	 
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware( [ 'auth', 'admin' ] );
		
		$this->picksController = new PicksEditController;
	}

	/**
	 * Recalculate standings of the given season.
	 *
	 * @param	\App\Season	$season
	 *
	 * @return	\Illuminate\Http\Response
	 */
	public function recalculate( Season $season )
	{
		$this->clear($season);
		
		$this->add($season);
		
		return redirect()->back();
	}
	
	/**
	 * Clear standings of this season.
	 *
	 * @param	\App\Season	$season
	 *
	 * @return	void
	 */
	protected function clear( Season $season )
	{
		Standing::whereIn( 'race_id', $season->races->pluck('id') )->delete();
	}
	
	/**
	 * Add standings of this season.
	 *
	 * @param	\App\Season	$season
	 *
	 * @return	void
	 */
	protected function add( Season $season )
	{
		$races		= $season->races()->has('results')->get();
		$previous	= [];
		
		foreach( $season->series->leagues as $league )
		{
			foreach( $races as $race )
			{
				foreach( $league->users as $user )
				{
					if( $user->picks->where( 'race_id', $race->id )->isEmpty() )
					{
						if( !isset( $previous[ $league->id ][ $user->id ] ) )
							continue;
						
						$previousStanding	= $previous[ $league->id ][ $user->id ];
						
						$this->picksController->carryOver( $user, $previousStanding->race, $race );
					}
					
					$standing = new Standing;
					
					$standing->user_id		= $user->id;
					$standing->league_id		= $league->id;
					$standing->race_id		= $race->id;
					
					if( isset( $previous[ $league->id ][ $user->id ] ) )
						$standing->previous()->associate( $previous[ $league->id ][ $user->id ] );
					
					$this->calculatePoints($standing);
					
					$standing->save();

					$previous[ $league->id ][ $user->id ] = $standing;
				}
				
				$this->setRankings($league, $race);
			}
		}
	}
	
	/**
	 * Calculate points for this standing.
	 *
	 * @param	\App\Standing	$standing
	 *
	 * @return	void
	 */
	protected function calculatePoints( Standing $standing )
	{
		$picks				= Pick::byRaceAndUser( $standing->race, $standing->user )->get();
		
		$results			= $standing->race->results;
		
		$standing->picked		= $results->where( 'rank', '<=', config('picks.max') )->whereIn( 'entry_id', $picks->pluck('entry_id') )->count();
		
		$standing->positions_correct	= $results->sum(function ($result) use($picks) {
			return $picks->where( 'rank', $result->rank )->where( 'entry_id', $result->entry_id )->count();
		});
		
		$standing->save();
	}
	
	/**
	 * Set the rank of a standing.
	 *
	 * @param	\App\League	$league
	 * @param	\App\Race	$race
	 *
	 * @return	void
	 */
	protected function setRankings( League $league, Race $race )
	{
		$standings = $league->standings()->where( 'race_id', $race->id )->get()->sort(function ($a, $b) {
			 foreach( [ 'totalOverall', 'totalPositionsCorrect', 'totalPicked', 'previousRank' ] as $attr )
			 {
			 	switch( $b->{$attr} <=> $a->{$attr} )
			 	{
			 		case -1;
			 			return -1;
			 		
			 		case 1;
			 			return 1;
			 	}
			 }
			 
			 return 0;
		});
		
		$previous	= new Standing;
		$currentRank	= 1;
		$previousRank	= 1;
		
		foreach( $standings as $standing )
		{
			if( $previous->totalOverall == $standing->totalOverall and $previous->totalPositionsCorrect == $standing->totalPositionsCorrect and $previous->totalPicked == $standing->totalPicked )
			{
				$standing->rank = $previousRank;
			}
			else
			{
				$standing->rank = $currentRank;
				
				$previousRank = $currentRank;
			}
			
			$standing->save();
			
			$currentRank++;
			$previous = $standing;
		}
	}
}