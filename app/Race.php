<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Race extends Model
{
	protected $dates = [
		'weekend_start',
		'created_at',
		'updated_at',
	];
	
	/**
	* The "booting" method of the model.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('sortByRaceDay', function (Builder $builder) {
		    $builder->orderBy('race_day');
		});
	}

	/**
	 * Get the circuit of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function circuit()
	{
		return $this->belongsTo( Circuit::class );
	}
	
	/**
	 * Get the season of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function season()
	{
		return $this->belongsTo( Season::class );
	}
	
	/**
	 * Get the results of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function results()
	{
		return $this->hasMany( Result::class );
	}
	
	/**
	 * Get the standings of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function standings()
	{
		return $this->hasMany( Standing::class );
	}
	
	/**
	 * Get the picks of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function picks()
	{
		return $this->hasMany( Pick::class );
	}
	
	/**
	 * Get next race according to current date.
	 *
	 * @param	$query	\Illuminate\Database\Eloquent\Builder
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeNextOrLast( Builder $query )
	{
		$newQuery = clone $query;
		
		$first = $query->where( 'race_day', '>=', date('Y-m-d') )->first();
		
		if( $first )
			return $first;
		
		return $newQuery->withoutGlobalScope('sortByRaceDay')->orderBy( 'race_day', 'desc' )->first();
	}
	
	/**
	 * Can we pick for this race?
	 *
	 * @return	bool
	 */
	public function getPickableAttribute()
	{
		return false;
	}
}
