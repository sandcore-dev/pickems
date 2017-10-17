<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
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
}
