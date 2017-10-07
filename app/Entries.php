<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
	/**
	 * Get team of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function team()
	{
		return $this->hasOne( Teams::class, 'team_id' );
	}
	 
	/**
	 * Get driver of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function driver()
	{
		return $this->hasOne( Drivers::class, 'driver_id' );
	}
	 
	/**
	 * Get season of this entry.
	 *
	 * @return	\Illuminate\Database\Eloquent\Collection
	 */
	public function season()
	{
		return $this->hasOne( Seasons::class, 'season_id' );
	}
}
