<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
	/**
	 * Get the circuit of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function circuit()
	{
		return $this->hasOne( Circuit::class );
	}
	
	/**
	 * Get the season of this race.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function season()
	{
		return $this->hasOne( Season::class );
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
}
