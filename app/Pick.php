<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Collections\PickCollection;

class Pick extends Model
{
	/**
	 * The attributes that are mass-assignable.
	 *
	 * @var		array
	 */
	protected $fillable = [ 'race_id', 'entry_id', 'league_user_id', 'rank', 'carry_over' ];
	
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
		return $this->belongsTo( User::class, 'league_user_id' );
	}

	/**
	 * Get the league of this pick.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function league()
	{
		return $this->belongsTo( League::class, 'league_user_id' );
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
