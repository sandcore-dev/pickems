<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\User;
use App\Race;

use App\Collections\PickCollection;

class Pick extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'race_id', 'entry_id', 'user_id', 'rank', 'carry_over' ];
	
	/**
	* Creates a new Collection instance of this model.
	*
	* @param	array	$models
	*
	* @return	\Illuminate\Database\Eloquent\Collection
	*/
	public function newCollection( array $models = [] )
	{
		return new PickCollection( $models );
	}

	/**
	 * Get the race of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function race()
	{
		return $this->belongsTo( Race::class );
	}

	/**
	 * Get the entry of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function entry()
	{
		return $this->belongsTo( Entry::class );
	}

	/**
	 * Get the user of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function user()
	{
		return $this->belongsTo( User::class );
	}
	
	/**
	 * Scope to race and user.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\Race				$race
	 * @param	\App\User				$user
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByRaceAndUser( Builder $query, Race $race, User $user )
	{
		return $query->byRace($race)->byUser($user);
	}

	/**
	 * Scope to race.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\Race				$race
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByRace( Builder $query, Race $race )
	{
		return $query->where( 'race_id', $race->id );
	}

	/**
	 * Scope to user.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\User				$user
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByUser( Builder $query, User $user )
	{
		return $query->where( 'user_id', $user->id );
	}

	/**
	 * Calculate the points of this pick.
	 *
	 * @return	integer|null
	 */
	public function getPointsAttribute()
	{
		if( $this->race->results->isEmpty() )
			return null;
		
		$result		= $this->race->results->where( 'rank', '<=', config('picks.max') )->whereIn( 'entry_id', $this->entry_id );
		
		$points		= $result->count();
		
		if( $points )
			$points	+= $result->first()->rank == $this->rank ? 1 : 0;
		
		return $points;
	}
}
