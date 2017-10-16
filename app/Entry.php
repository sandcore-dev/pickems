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
		return $this->hasOne( Team::class );
	}
	 
	/**
	 * Get driver of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function driver()
	{
		return $this->hasOne( Driver::class );
	}
	 
	/**
	 * Get season of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function season()
	{
		return $this->hasOne( Season::class );
	}
}
