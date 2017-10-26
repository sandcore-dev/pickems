<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Entry extends Model
{
	/**
	* The "booting" method of the model.
	*
	* @return void
	*/
	protected static function boot()
	{
		parent::boot();
	}

	/**
	 * Get team of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function team()
	{
		return $this->belongsTo( Team::class );
	}
	 
	/**
	 * Get driver of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function driver()
	{
		return $this->belongsTo( Driver::class );
	}
	 
	/**
	 * Get season of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function season()
	{
		return $this->belongsTo( Season::class );
	}
	 
	/**
	 * Get results of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function results()
	{
		return $this->hasMany( Result::class );
	}
	 
	/**
	 * Get picks of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function picks()
	{
		return $this->hasMany( Pick::class );
	}

	/**
	 * Get active entries.
	 *
	 * @param	$query	\Illuminate\Database\Eloquent\Builder
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive( Builder $query )
	{
		return $query->where('active', 1);
	}

	/**
	 * Order by teams and drivers.
	 *
	 * @param	$query	\Illuminate\Database\Eloquent\Builder
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeSortByTeamDriver( Builder $query )
	{
		return $query->with([
			'team' => function ($query) {
				$query->orderBy( 'name', 'asc' );
			},
			'driver' => function ($query) {
				$query->orderBy( 'last_name', 'asc' );
				$query->orderBy( 'first_name', 'asc' );
			},
		]);
	}
}
