<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Races extends Model
{
	/**
	 * Get the circuit of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function circuit()
	{
		return $this->hasOne( Circuits::class, 'circuit_id' );
	}
	
	/**
	 * Get the season of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function season()
	{
		return $this->hasOne( Seasons::class, 'season_id' );
	}
	
	/**
	 * Get the results of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function results()
	{
		return $this->hasMany( Results::class, 'race_id' );
	}
}
