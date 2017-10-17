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
}
